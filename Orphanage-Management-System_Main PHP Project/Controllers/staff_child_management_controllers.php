<?php


$staffResult = $conn->query("SELECT user_id, username FROM Users WHERE role = 'Staff'");
$staff = [];
while ($row = $staffResult->fetch_assoc()) {
    $staff[] = $row;
}

$childrenResult = $conn->query("SELECT child_id, first_name, last_name FROM Children");
$children = [];
while ($row = $childrenResult->fetch_assoc()) {
    $children[] = $row;
}

$statusMessage = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['assign_staff'])) {
        $child_id = $_POST['child_id'];
        $staff_id = $_POST['staff_id'];

        $stmt = $conn->prepare("INSERT INTO StaffAssignments (child_id, staff_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $child_id, $staff_id);
        if ($stmt->execute()) {
            $statusMessage = 'Staff assigned successfully';
        } else {
            $statusMessage = 'Failed to assign staff';
        }
        $stmt->close();
    } elseif (isset($_POST['delete_assignment'])) {
        $assignment_id = $_POST['assignment_id'];

        $stmt = $conn->prepare("DELETE FROM StaffAssignments WHERE assignment_id = ?");
        $stmt->bind_param("i", $assignment_id);
        if ($stmt->execute()) {
            $statusMessage = 'Assignment deleted successfully';
        } else {
            $statusMessage = 'Failed to delete assignment';
        }
        $stmt->close();
    } elseif (isset($_POST['edit_assignment'])) {
        $assignment_id = $_POST['assignment_id'];
        $child_id = $_POST['child_id'];
        $staff_id = $_POST['staff_id'];

        $stmt = $conn->prepare("UPDATE StaffAssignments SET child_id = ?, staff_id = ? WHERE assignment_id = ?");
        $stmt->bind_param("iii", $child_id, $staff_id, $assignment_id);
        if ($stmt->execute()) {
            $statusMessage = 'Assignment updated successfully';
        } else {
            $statusMessage = 'Failed to update assignment';
        }
        $stmt->close();
    }
}

$assignmentsResult = $conn->query("
    SELECT sa.assignment_id, sa.child_id, sa.staff_id, sa.assigned_at, c.first_name AS child_first_name, c.last_name AS child_last_name, u.username AS staff_username
    FROM StaffAssignments sa
    JOIN Children c ON sa.child_id = c.child_id
    JOIN Users u ON sa.staff_id = u.user_id
    ORDER BY sa.assigned_at DESC
");


?>
