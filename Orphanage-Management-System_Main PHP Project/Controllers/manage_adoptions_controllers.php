<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_adoption'])) {
        $child_id = $_POST['child_id'];
        $adopter_name = $_POST['adopter_name'];
        $adopter_contact = $_POST['adopter_contact'];
        $adopter_nid = $_POST['adopter_nid'];
        $adoption_date = $_POST['adoption_date'];

        $stmt = $conn->prepare("INSERT INTO adoptions (child_id, adopter_name, adopter_contact, adopter_nid, adoption_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $child_id, $adopter_name, $adopter_contact, $adopter_nid, $adoption_date);
        if ($stmt->execute()) {
            $statusMessage = "Adoption record added successfully.";
        } else {
            $statusMessage = "Error adding adoption record.";
        }
        $stmt->close();
    } elseif (isset($_POST['edit_adoption'])) {
        $adoption_id = $_POST['adoption_id'];
        $child_id = $_POST['child_id'];
        $adopter_name = $_POST['adopter_name'];
        $adopter_contact = $_POST['adopter_contact'];
        $adopter_nid = $_POST['adopter_nid'];
        $adoption_date = $_POST['adoption_date'];

        $stmt = $conn->prepare("UPDATE adoptions SET child_id = ?, adopter_name = ?, adopter_contact = ?, adopter_nid = ?, adoption_date = ? WHERE adoption_id = ?");
        $stmt->bind_param("issssi", $child_id, $adopter_name, $adopter_contact, $adopter_nid, $adoption_date, $adoption_id);
        if ($stmt->execute()) {
            $statusMessage = "Adoption record updated successfully.";
        } else {
            $statusMessage = "Error updating adoption record.";
        }
        $stmt->close();
    } elseif (isset($_POST['delete_adoption'])) {
        $adoption_id = $_POST['adoption_id'];

        $stmt = $conn->prepare("DELETE FROM adoptions WHERE adoption_id = ?");
        $stmt->bind_param("i", $adoption_id);
        if ($stmt->execute()) {
            $statusMessage = "Adoption record deleted successfully.";
        } else {
            $statusMessage = "Error deleting adoption record.";
        }
        $stmt->close();
    }
}

$adoptions = [];
$result = $conn->query("SELECT adoptions.*, children.first_name, children.last_name FROM adoptions JOIN children ON adoptions.child_id = children.child_id");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $adoptions[] = $row;
    }
}

$children = [];
$result = $conn->query("SELECT child_id, first_name, last_name FROM children");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $children[] = $row;
    }
}
?>
