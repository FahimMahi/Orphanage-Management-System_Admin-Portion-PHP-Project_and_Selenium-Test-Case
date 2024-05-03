<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: login.php");
    exit();
}


include('../Models/config.php');
include('../Controllers/health_records_controllers.php');

include('navbar.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Health Records - Orphanage Management System</title>
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
        .form-container input[type="date"],
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
            background: url('../img/12062594_4872305.jpg') no-repeat center center fixed;
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

        <div class="form-container">
        <h2>Health Records</h2>
            <h3><?php echo $editRecord ? 'Edit Health Record' : 'Add Health Record'; ?></h3>
            <form id="record-form" action="health_records.php" method="post" onsubmit="return validateForm();">
                <?php if ($editRecord): ?>
                    <input type="hidden" name="record_id" value="<?php echo $editRecord['record_id']; ?>">
                <?php endif; ?>
                <label for="child_id">Child:</label>
                <select name="child_id" id="child_id" required>
                    <option value="">Select Child</option>
                    <?php foreach ($children as $child): ?>
                        <option value="<?php echo $child['child_id']; ?>" <?php echo isset($editRecord) && $editRecord['child_id'] == $child['child_id'] ? 'selected' : ''; ?>>
                            <?php echo $child['child_id'] . ' - ' . $child['first_name'] . ' ' . $child['last_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="medical_history">Medical History:</label>
                <textarea id="medical_history" name="medical_history" rows="4" required><?php echo $editRecord['medical_history'] ?? ''; ?></textarea>

                <label for="vaccinations">Vaccinations:</label>
                <textarea id="vaccinations" name="vaccinations" rows="2" required><?php echo $editRecord['vaccinations'] ?? ''; ?></textarea>

                <label for="treatments">Treatments:</label>
                <textarea id="treatments" name="treatments" rows="2" required><?php echo $editRecord['treatments'] ?? ''; ?></textarea>

                <label for="last_checkup">Last Checkup:</label>
                <input type="date" id="last_checkup" name="last_checkup" value="<?php echo $editRecord['last_checkup'] ?? ''; ?>" required>

                <label for="next_appointment">Next Appointment:</label>
                <input type="date" id="next_appointment" name="next_appointment" value="<?php echo $editRecord['next_appointment'] ?? ''; ?>" required>

                <input type="submit" name="<?php echo $editRecord ? 'edit_record' : 'add_record'; ?>" value="<?php echo $editRecord ? 'Edit Health Record' : 'Add Health Record'; ?>">
            </form>
        </div>

        <div class="record-list">
            <h3>Existing Health Records</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Child ID</th>
                        <th>Medical History</th>
                        <th>Vaccinations</th>
                        <th>Treatments</th>
                        <th>Last Checkup</th>
                        <th>Next Appointment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['record_id']; ?></td>
                            <td><?php echo $row['child_id']; ?></td>
                            <td><?php echo $row['medical_history']; ?></td>
                            <td><?php echo $row['vaccinations']; ?></td>
                            <td><?php echo $row['treatments']; ?></td>
                            <td><?php echo $row['last_checkup']; ?></td>
                            <td><?php echo $row['next_appointment']; ?></td>
                            <td>
                                <form action="health_records.php" method="get" style="display:inline;">
                                    <input type="hidden" name="edit_record_id" value="<?php echo $row['record_id']; ?>">
                                    <input type="submit" value="Edit" class="edit-button">
                                </form>
                                <form action="health_records.php" method="post" style="display:inline;">
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
            var medicalHistory = document.getElementById('medical_history').value.trim();
            var vaccinations = document.getElementById('vaccinations').value.trim();
            var treatments = document.getElementById('treatments').value.trim();
            var lastCheckup = document.getElementById('last_checkup').value;
            var nextAppointment = document.getElementById('next_appointment').value;

            if (childId === '') {
                alert('Child ID is required.');
                return false;
            }

            if (medicalHistory === '') {
                alert('Medical History is required.');
                return false;
            }

            if (vaccinations === '') {
                alert('Vaccinations are required.');
                return false;
            }

            if (treatments === '') {
                alert('Treatments are required.');
                return false;
            }

            if (lastCheckup === '') {
                alert('Last Checkup date is required.');
                return false;
            }

            if (nextAppointment === '') {
                alert('Next Appointment date is required.');
                return false;
            }

            return true;
        }
    </script>
    <?php include('footer.php'); ?>
</body>
</html>
