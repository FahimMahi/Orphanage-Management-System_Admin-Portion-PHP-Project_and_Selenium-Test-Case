<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: login.php");
    exit();
}

include('../Models/config.php');
include('../Controllers/generate_reports_controllers.php');

include('navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Generate Reports - Orphanage Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .report-section {
            background-color: #fff;
            margin: 20px 0;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .report-section h3 {
            margin-top: 0;
            color: #333;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .report-table th {
            background-color: #f4f4f4;
            color: #333;
        }

        .report-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .report-table tbody tr:hover {
            background-color: #f1f1f1;
        }
        body {
            font-family: Arial, sans-serif;
            background: url('../img/business-accessories-objects-top-view.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">

        <div class="report-section">
        <h2>Generate Reports</h2>
            <h3>Child Welfare Report</h3>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Child ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Admission Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $childrenResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['child_id']; ?></td>
                            <td><?php echo $row['first_name']; ?></td>
                            <td><?php echo $row['last_name']; ?></td>
                            <td><?php echo $row['date_of_birth']; ?></td>
                            <td><?php echo $row['gender']; ?></td>
                            <td><?php echo $row['admission_date']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="report-section">
            <h3>Educational Performance Report</h3>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Record ID</th>
                        <th>Child ID</th>
                        <th>School Name</th>
                        <th>Grade</th>
                        <th>Performance</th>
                        <th>Extracurricular Activities</th>
                        <th>Attendance</th>
                        <th>Class</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $educationResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['record_id']; ?></td>
                            <td><?php echo $row['child_id']; ?></td>
                            <td><?php echo $row['school_name']; ?></td>
                            <td><?php echo $row['grade']; ?></td>
                            <td><?php echo $row['performance']; ?></td>
                            <td><?php echo $row['extracurricular_activities']; ?></td>
                            <td><?php echo $row['attendance']; ?></td>
                            <td><?php echo $row['class']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="report-section">
            <h3>Health Records Report</h3>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Record ID</th>
                        <th>Child ID</th>
                        <th>Medical History</th>
                        <th>Vaccinations</th>
                        <th>Treatments</th>
                        <th>Last Checkup</th>
                        <th>Next Appointment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $healthResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['record_id']; ?></td>
                            <td><?php echo $row['child_id']; ?></td>
                            <td><?php echo $row['medical_history']; ?></td>
                            <td><?php echo $row['vaccinations']; ?></td>
                            <td><?php echo $row['treatments']; ?></td>
                            <td><?php echo $row['last_checkup']; ?></td>
                            <td><?php echo $row['next_appointment']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>
