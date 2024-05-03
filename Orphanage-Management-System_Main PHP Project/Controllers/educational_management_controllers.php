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

function getEducationalRecordById($conn, $record_id) {
    $stmt = $conn->prepare("SELECT record_id, child_id, school_name, grade, performance, extracurricular_activities, attendance, class FROM EducationalRecords WHERE record_id = ?");
    $stmt->bind_param("i", $record_id);
    $stmt->execute();

    $record_id = $child_id = $school_name = $grade = $performance = $extracurricular_activities = $attendance = $class = null;

    $stmt->bind_result($record_id, $child_id, $school_name, $grade, $performance, $extracurricular_activities, $attendance, $class);
    $stmt->fetch();
    $stmt->close();

    return ['record_id' => $record_id, 'child_id' => $child_id, 'school_name' => $school_name, 'grade' => $grade, 'performance' => $performance, 'extracurricular_activities' => $extracurricular_activities, 'attendance' => $attendance, 'class' => $class];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_record'])) {
        $child_id = $_POST['child_id'];
        $school_name = $_POST['school_name'];
        $grade = $_POST['grade'];
        $performance = $_POST['performance'];
        $extracurricular_activities = $_POST['extracurricular_activities'];
        $attendance = $_POST['attendance'];
        $class = $_POST['class'];

        $stmt = $conn->prepare("INSERT INTO EducationalRecords (child_id, school_name, grade, performance, extracurricular_activities, attendance, class, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->bind_param("issssss", $child_id, $school_name, $grade, $performance, $extracurricular_activities, $attendance, $class);
        if ($stmt->execute()) {
            $statusMessage = 'Educational record added successfully';
        }
        $stmt->close();
    } elseif (isset($_POST['delete_record'])) {
        $record_id = $_POST['record_id'];

        $stmt = $conn->prepare("DELETE FROM EducationalRecords WHERE record_id = ?");
        $stmt->bind_param("i", $record_id);
        if ($stmt->execute()) {
            $statusMessage = 'Educational record deleted successfully';
        }
        $stmt->close();
    } elseif (isset($_POST['edit_record'])) {
        $record_id = $_POST['record_id'];
        $child_id = $_POST['child_id'];
        $school_name = $_POST['school_name'];
        $grade = $_POST['grade'];
        $performance = $_POST['performance'];
        $extracurricular_activities = $_POST['extracurricular_activities'];
        $attendance = $_POST['attendance'];
        $class = $_POST['class'];

        $stmt = $conn->prepare("UPDATE EducationalRecords SET child_id = ?, school_name = ?, grade = ?, performance = ?, extracurricular_activities = ?, attendance = ?, class = ?, updated_at = NOW() WHERE record_id = ?");
        $stmt->bind_param("issssssi", $child_id, $school_name, $grade, $performance, $extracurricular_activities, $attendance, $class, $record_id);
        if ($stmt->execute()) {
            $statusMessage = 'Educational record updated successfully';
        }
        $stmt->close();
    }
}

$result = $conn->query("SELECT record_id, child_id, school_name, grade, performance, extracurricular_activities, attendance, class FROM EducationalRecords");

$editRecord = null;
if (isset($_GET['edit_record_id'])) {
    $editRecord = getEducationalRecordById($conn, $_GET['edit_record_id']);
}

$children = getChildren($conn);
?>
