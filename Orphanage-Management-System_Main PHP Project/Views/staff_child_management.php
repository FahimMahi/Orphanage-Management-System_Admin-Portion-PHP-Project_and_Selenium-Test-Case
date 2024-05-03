
<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: login.php");
    exit();
}

include('../Models/config.php');
include('../Controllers/staff_child_management_controllers.php');

include('navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Staff Child Management - Orphanage Management System</title>
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

        .management-section {
            background-color: #fff;
            margin: 20px 0;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .management-section h3 {
            margin-top: 0;
            color: #333;
        }

        .management-form {
            margin-bottom: 20px;
        }

        .management-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .management-form select,
        .management-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .assignment-list {
            margin-top: 20px;
        }

        .assignment-list table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
        }

        .assignment-list th,
        .assignment-list td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .assignment-list th {
            background-color: #f4f4f4;
            color: #333;
        }

        .assignment-list tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .assignment-list tbody tr:hover {
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

        .edit-assignment-form {
            display: none;
            margin-top: 20px;
        }
        body {
            font-family: Arial, sans-serif;
            background: url('../img/2302_q893_004.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">

        <div class="management-section">
        <h2>Staff Child Management</h2>
            <h3>Assign Staff to Child</h3>
            <form class="management-form" action="staff_child_management.php" method="post" onsubmit="return validateAssignForm();">
                <label for="child_id">Child:</label>
                <select name="child_id" id="child_id" >
                    <option value="">Select Child</option>
                    <?php foreach ($children as $child): ?>
                        <option value="<?php echo $child['child_id']; ?>"><?php echo $child['first_name'] . ' ' . $child['last_name']; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="staff_id">Staff:</label>
                <select name="staff_id" id="staff_id" >
                    <option value="">Select Staff</option>
                    <?php foreach ($staff as $s): ?>
                        <option value="<?php echo $s['user_id']; ?>"><?php echo $s['username']; ?></option>
                    <?php endforeach; ?>
                </select>

                <input type="submit" name="assign_staff" value="Assign Staff">
            </form>
        </div>

        <div class="management-section">
            <h3>Current Assignments</h3>
            <div class="assignment-list">
                <table>
                    <thead>
                        <tr>
                            <th>Assignment ID</th>
                            <th>Child</th>
                            <th>Staff</th>
                            <th>Assigned At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $assignmentsResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['assignment_id']; ?></td>
                                <td><?php echo $row['child_first_name'] . ' ' . $row['child_last_name']; ?></td>
                                <td><?php echo $row['staff_username']; ?></td>
                                <td><?php echo $row['assigned_at']; ?></td>
                                <td>
                                    <button class="edit-button" onclick="showEditForm(<?php echo $row['assignment_id']; ?>, <?php echo $row['child_id']; ?>, <?php echo $row['staff_id']; ?>)">Edit</button>
                                    <form action="staff_child_management.php" method="post" style="display:inline;">
                                        <input type="hidden" name="assignment_id" value="<?php echo $row['assignment_id']; ?>">
                                        <input type="submit" name="delete_assignment" value="Delete" class="delete-button" onclick="return confirm('Are you sure you want to delete this assignment?');">
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div id="edit-assignment-form" class="edit-assignment-form">
                <h3>Edit Assignment</h3>
                <form class="management-form" action="staff_child_management.php" method="post" onsubmit="return validateEditForm();">
                    <input type="hidden" name="assignment_id" id="edit-assignment-id">
                    <label for="edit-child-id">Child:</label>
                    <select name="child_id" id="edit-child-id" required>
                        <option value="">Select Child</option>
                        <?php foreach ($children as $child): ?>
                            <option value="<?php echo $child['child_id']; ?>"><?php echo $child['first_name'] . ' ' . $child['last_name']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="edit-staff-id">Staff:</label>
                    <select name="staff_id" id="edit-staff-id" required>
                        <option value="">Select Staff</option>
                        <?php foreach ($staff as $s): ?>
                            <option value="<?php echo $s['user_id']; ?>"><?php echo $s['username']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <input type="submit" name="edit_assignment" value="Update Assignment">
                </form>
            </div>
        </div>
    </div>

    <?php if ($statusMessage): ?>
        <script>
            alert('<?php echo $statusMessage; ?>');
        </script>
    <?php endif; ?>

    <script>
        function validateAssignForm() {
            var childId = document.getElementById('child_id').value.trim();
            var staffId = document.getElementById('staff_id').value.trim();

            if (childId === '') {
                alert('Child is required.');
                return false;
            }

            if (staffId === '') {
                alert('Staff is required.');
                return false;
            }

            return true;
        }

        function validateEditForm() {
            var childId = document.getElementById('edit-child-id').value.trim();
            var staffId = document.getElementById('edit-staff-id').value.trim();

            if (childId === '') {
                alert('Child is required.');
                return false;
            }

            if (staffId === '') {
                alert('Staff is required.');
                return false;
            }

            return true;
        }

        function showEditForm(assignmentId, childId, staffId) {
            document.getElementById('edit-assignment-id').value = assignmentId;
            document.getElementById('edit-child-id').value = childId;
            document.getElementById('edit-staff-id').value = staffId;
            document.getElementById('edit-assignment-form').style.display = 'block';
        }
    </script>
    <?php include('footer.php'); ?>
</body>
</html>
