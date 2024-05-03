<?php
$statusMessage = '';

function getChildById($conn, $child_id) {
    $stmt = $conn->prepare("SELECT child_id, first_name, last_name, date_of_birth, gender, admission_date FROM Children WHERE child_id = ?");
    $stmt->bind_param("i", $child_id);
    $stmt->execute();

    $child_id = $first_name = $last_name = $date_of_birth = $gender = $admission_date = null;

    $stmt->bind_result($child_id, $first_name, $last_name, $date_of_birth, $gender, $admission_date);
    $stmt->fetch();
    $stmt->close();

    return ['child_id' => $child_id, 'first_name' => $first_name, 'last_name' => $last_name, 'date_of_birth' => $date_of_birth, 'gender' => $gender, 'admission_date' => $admission_date];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_child'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $date_of_birth = $_POST['date_of_birth'];
        $gender = $_POST['gender'];
        $admission_date = $_POST['admission_date'];

        $stmt = $conn->prepare("INSERT INTO Children (first_name, last_name, date_of_birth, gender, admission_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $first_name, $last_name, $date_of_birth, $gender, $admission_date);
        if ($stmt->execute()) {
            $statusMessage = 'Child added successfully';
        }
        $stmt->close();
    } elseif (isset($_POST['delete_child'])) {
        $child_id = $_POST['child_id'];

        $stmt = $conn->prepare("DELETE FROM Children WHERE child_id = ?");
        $stmt->bind_param("i", $child_id);
        if ($stmt->execute()) {
            $statusMessage = 'Child deleted successfully';
        }
        $stmt->close();
    } elseif (isset($_POST['edit_child'])) {
        $child_id = $_POST['child_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $date_of_birth = $_POST['date_of_birth'];
        $gender = $_POST['gender'];
        $admission_date = $_POST['admission_date'];

        $stmt = $conn->prepare("UPDATE Children SET first_name = ?, last_name = ?, date_of_birth = ?, gender = ?, admission_date = ? WHERE child_id = ?");
        $stmt->bind_param("sssssi", $first_name, $last_name, $date_of_birth, $gender, $admission_date, $child_id);
        if ($stmt->execute()) {
            $statusMessage = 'Child updated successfully';
        }
        $stmt->close();
    }
}

$result = $conn->query("SELECT child_id, first_name, last_name, date_of_birth, gender, admission_date FROM Children");

$editChild = null;
if (isset($_GET['edit_child_id'])) {
    $editChild = getChildById($conn, $_GET['edit_child_id']);
}
?>
