<?php

$childrenResult = $conn->query("SELECT child_id, first_name, last_name, date_of_birth, gender, admission_date FROM Children");

$educationResult = $conn->query("SELECT record_id, child_id, school_name, grade, performance, extracurricular_activities, attendance, class FROM EducationalRecords");

$healthResult = $conn->query("SELECT record_id, child_id, medical_history, vaccinations, treatments, last_checkup, next_appointment FROM HealthRecords");
?>
