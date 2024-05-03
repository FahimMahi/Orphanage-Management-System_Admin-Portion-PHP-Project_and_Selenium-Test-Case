<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: login.php");
    exit();
}


include('../Models/config.php');
include('../Controllers/educational_management_controllers.php');

include('navbar.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Educational Management - Orphanage Management System</title>
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

        .form-container {
            margin: 20px 0;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h3 {
            margin-top: 0;
            color: #333;
        }

        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-container input[type="text"],
        .form-container textarea,
        .form-container select {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container input[type="submit"] {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .form-container input[type="submit"]:hover {
            background-color: #218838;
        }

        .record-list {
            margin: 20px 0;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .record-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .record-list th,
        .record-list td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .record-list th {
            background-color: #f4f4f4;
        }

        .record-list tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .record-list tbody tr:hover {
            background-color: #f1f1f1;
        }

        .edit-button,
        .delete-button {
            background-color: #ffc107;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-button:hover {
            background-color: #e0a800;
        }

        .delete-button {
            background-color: #dc3545;
        }

        .delete-button:hover {
            background-color: #c82333;
        }
        body {
            font-family: Arial, sans-serif;
            background: url('../img/29012291_7524843.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>

        <div class="form-container">
        <h2>Educational Management</h2>
            <h3><?php echo $editRecord ? 'Edit Educational Record' : 'Add Educational Record'; ?></h3>
            <form id="record-form" action="educational_management.php" method="post" onsubmit="return validateForm();">
                <?php if ($editRecord): ?>
                    <input type="hidden" name="record_id" value="<?php echo $editRecord['record_id']; ?>">
                <?php endif; ?>
                <label for="child_id">Child:</label>
                <select name="child_id" id="child_id" >
                    <option value="">Select Child</option>
                    <?php foreach ($children as $child): ?>
                        <option value="<?php echo $child['child_id']; ?>" <?php echo isset($editRecord) && $editRecord['child_id'] == $child['child_id'] ? 'selected' : ''; ?>>
                            <?php echo $child['child_id'] . ' - ' . $child['first_name'] . ' ' . $child['last_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="school_name">School Name:</label>
                <input type="text" id="school_name" name="school_name" value="<?php echo $editRecord['school_name'] ?? ''; ?>" >

                <label for="grade">Grade:</label>
                <input type="text" id="grade" name="grade" value="<?php echo $editRecord['grade'] ?? ''; ?>" >

                <label for="performance">Performance:</label>
                <textarea id="performance" name="performance" rows="4" ><?php echo $editRecord['performance'] ?? ''; ?></textarea>

                <label for="extracurricular_activities">Extracurricular Activities:</label>
                <textarea id="extracurricular_activities" name="extracurricular_activities" rows="2" ><?php echo $editRecord['extracurricular_activities'] ?? ''; ?></textarea>

                <label for="attendance">Attendance:</label>
                <textarea id="attendance" name="attendance" rows="2" ><?php echo $editRecord['attendance'] ?? ''; ?></textarea>

                <label for="class">Class:</label>
                <textarea id="class" name="class" rows="2" ><?php echo $editRecord['class'] ?? ''; ?></textarea>

                <input type="submit" name="<?php echo $editRecord ? 'edit_record' : 'add_record'; ?>" value="<?php echo $editRecord ? 'Edit Educational Record' : 'Add Educational Record'; ?>">
            </form>
        </div>

        <div class="record-list">
            <h3>Existing Educational Records</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Child ID</th>
                        <th>School Name</th>
                        <th>Grade</th>
                        <th>Performance</th>
                        <th>Extracurricular Activities</th>
                        <th>Attendance</th>
                        <th>Class</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['record_id']; ?></td>
                            <td><?php echo $row['child_id']; ?></td>
                            <td><?php echo $row['school_name']; ?></td>
                            <td><?php echo $row['grade']; ?></td>
                            <td><?php echo $row['performance']; ?></td>
                            <td><?php echo $row['extracurricular_activities']; ?></td>
                            <td><?php echo $row['attendance']; ?></td>
                            <td><?php echo $row['class']; ?></td>
                            <td>
                                <form action="educational_management.php" method="get" style="display:inline;">
                                    <input type="hidden" name="edit_record_id" value="<?php echo $row['record_id']; ?>">
                                    <input type="submit" value="Edit" class="edit-button">
                                </form>
                                <form action="educational_management.php" method="post" style="display:inline;">
                                    <input type="hidden" name="record_id" value="<?php echo $row['record_id']; ?>">
                                    <input type="submit" name="delete_record" value="Delete" class="delete-button" onclick="return confirm('Are you sure you want to delete this record?');">
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if ($statusMessage): ?>
        <script>
            alert('<?php echo $statusMessage; ?>');
        </script>
    <?php endif; ?>

    <script>
        function validateForm() {
            var childId = document.getElementById('child_id').value.trim();
            var schoolName = document.getElementById('school_name').value.trim();
            var grade = document.getElementById('grade').value.trim();
            var performance = document.getElementById('performance').value.trim();
            var extracurricularActivities = document.getElementById('extracurricular_activities').value.trim();
            var attendance = document.getElementById('attendance').value.trim();
            var classValue = document.getElementById('class').value.trim();

            if (childId === '') {
                alert('Child ID is required.');
                return false;
            }

            if (schoolName === '') {
                alert('School Name is required.');
                return false;
            }

            if (grade === '') {
                alert('Grade is required.');
                return false;
            }

            if (performance === '') {
                alert('Performance is required.');
                return false;
            }

            if (extracurricularActivities === '') {
                alert('Extracurricular Activities are required.');
                return false;
            }

            if (attendance === '') {
                alert('Attendance is required.');
                return false;
            }

            if (classValue === '') {
                alert('Class is required.');
                return false;
            }

            return true;
        }
    </script>
    <?php include('footer.php'); ?>
</body>
</html>
