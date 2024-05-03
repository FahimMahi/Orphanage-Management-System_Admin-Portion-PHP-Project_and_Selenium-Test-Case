<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: login.php");
    exit();
}

include('../Models/config.php');
include('../Controllers/child_records_controllers.php');
include('navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Child Records - Orphanage Management System</title>
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

        .child-list {
            margin: 20px 0;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .child-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .child-list th,
        .child-list td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .child-list th {
            background-color: #f4f4f4;
        }

        .child-list tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .child-list tbody tr:hover {
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
            background: url('../img/2304.q894.002.jpg') no-repeat center center fixed;
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
        <div class="form-container">
        <h2>Child Records</h2>
            <h3><?php echo $editChild ? 'Edit Child' : 'Add Child'; ?></h3>
            <form id="child-form" action="child_records.php" method="post" onsubmit="return validateForm();">
                <?php if ($editChild): ?>
                    <input type="hidden" name="child_id" value="<?php echo $editChild['child_id']; ?>">
                <?php endif; ?>
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo $editChild['first_name'] ?? ''; ?>" >

                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo $editChild['last_name'] ?? ''; ?>" >

                <label for="date_of_birth">Date of Birth:</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo $editChild['date_of_birth'] ?? ''; ?>" >

                <label for="gender">Gender:</label>
                <select name="gender" id="gender" required>
                    <option value="Male" <?php echo isset($editChild) && $editChild['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo isset($editChild) && $editChild['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                    <option value="Other" <?php echo isset($editChild) && $editChild['gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                </select>

                <label for="admission_date">Admission Date:</label>
                <input type="date" id="admission_date" name="admission_date" value="<?php echo $editChild['admission_date'] ?? ''; ?>" >

                <input type="submit" name="<?php echo $editChild ? 'edit_child' : 'add_child'; ?>" value="<?php echo $editChild ? 'Edit Child' : 'Add Child'; ?>">
            </form>
        </div>

        <div class="child-list">
            <h3>Existing Child Records</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Admission Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['child_id']; ?></td>
                            <td><?php echo $row['first_name']; ?></td>
                            <td><?php echo $row['last_name']; ?></td>
                            <td><?php echo $row['date_of_birth']; ?></td>
                            <td><?php echo $row['gender']; ?></td>
                            <td><?php echo $row['admission_date']; ?></td>
                            <td>
                                <form action="child_records.php" method="get" style="display:inline;">
                                    <input type="hidden" name="edit_child_id" value="<?php echo $row['child_id']; ?>">
                                    <input type="submit" value="Edit" class="edit-button">
                                </form>
                                <form action="child_records.php" method="post" style="display:inline;">
                                    <input type="hidden" name="child_id" value="<?php echo $row['child_id']; ?>">
                                    <input type="submit" name="delete_child" value="Delete" class="delete-button" onclick="return confirm('Are you sure you want to delete this child?');">
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
            var firstName = document.getElementById('first_name').value.trim();
            var lastName = document.getElementById('last_name').value.trim();
            var dateOfBirth = document.getElementById('date_of_birth').value;
            var gender = document.getElementById('gender').value;
            var admissionDate = document.getElementById('admission_date').value;

            if (firstName === '') {
                alert('First Name is required.');
                return false;
            }

            if (lastName === '') {
                alert('Last Name is required.');
                return false;
            }

            if (dateOfBirth === '') {
                alert('Date of Birth is required.');
                return false;
            }

            if (gender === '') {
                alert('Gender is required.');
                return false;
            }

            if (admissionDate === '') {
                alert('Admission Date is required.');
                return false;
            }

            return true;
        }
    </script>
    <?php include('footer.php'); ?>
</body>
</html>
