<?php
$statusMessage = '';

function getChildren($conn) {
    $result = $conn->query("SELECT child_id, first_name, last_name FROM Children");
    $children = [];
    while ($row = $result->fetch_assoc()) {
        $children[] = $row;
    }
    return $children;
}

function getHealthRecordById($conn, $record_id) {
    $stmt = $conn->prepare("SELECT record_id, child_id, medical_history, vaccinations, treatments, last_checkup, next_appointment FROM HealthRecords WHERE record_id = ?");
    $stmt->bind_param("i", $record_id);
    $stmt->execute();

    $record_id = $child_id = $medical_history = $vaccinations = $treatments = $last_checkup = $next_appointment = null;

    $stmt->bind_result($record_id, $child_id, $medical_history, $vaccinations, $treatments, $last_checkup, $next_appointment);
    $stmt->fetch();
    $stmt->close();

    return ['record_id' => $record_id, 'child_id' => $child_id, 'medical_history' => $medical_history, 'vaccinations' => $vaccinations, 'treatments' => $treatments, 'last_checkup' => $last_checkup, 'next_appointment' => $next_appointment];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_record'])) {
        $child_id = $_POST['child_id'];
        $medical_history = $_POST['medical_history'];
        $vaccinations = $_POST['vaccinations'];
        $treatments = $_POST['treatments'];
        $last_checkup = $_POST['last_checkup'];
        $next_appointment = $_POST['next_appointment'];

        $stmt = $conn->prepare("INSERT INTO HealthRecords (child_id, medical_history, vaccinations, treatments, last_checkup, next_appointment) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $child_id, $medical_history, $vaccinations, $treatments, $last_checkup, $next_appointment);
        if ($stmt->execute()) {
            $statusMessage = 'Health record added successfully';
        }
        $stmt->close();
    } elseif (isset($_POST['delete_record'])) {
        $record_id = $_POST['record_id'];

        $stmt = $conn->prepare("DELETE FROM HealthRecords WHERE record_id = ?");
        $stmt->bind_param("i", $record_id);
        if ($stmt->execute()) {
            $statusMessage = 'Health record deleted successfully';
        }
        $stmt->close();
    } elseif (isset($_POST['edit_record'])) {
        $record_id = $_POST['record_id'];
        $child_id = $_POST['child_id'];
        $medical_history = $_POST['medical_history'];
        $vaccinations = $_POST['vaccinations'];
        $treatments = $_POST['treatments'];
        $last_checkup = $_POST['last_checkup'];
        $next_appointment = $_POST['next_appointment'];

        $stmt = $conn->prepare("UPDATE HealthRecords SET child_id = ?, medical_history = ?, vaccinations = ?, treatments = ?, last_checkup = ?, next_appointment = ? WHERE record_id = ?");
        $stmt->bind_param("isssssi", $child_id, $medical_history, $vaccinations, $treatments, $last_checkup, $next_appointment, $record_id);
        if ($stmt->execute()) {
            $statusMessage = 'Health record updated successfully';
        }
        $stmt->close();
    }
}

$result = $conn->query("SELECT record_id, child_id, medical_history, vaccinations, treatments, last_checkup, next_appointment FROM HealthRecords");

$editRecord = null;
if (isset($_GET['edit_record_id'])) {
    $editRecord = getHealthRecordById($conn, $_GET['edit_record_id']);
}

// for the dropdown
$children = getChildren($conn);
?>
