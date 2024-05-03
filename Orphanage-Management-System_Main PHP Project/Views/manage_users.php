<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: login.php");
    exit();
}

include('../Models/config.php');
include('../Controllers/manage_users_controller.php');

include('navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Manage Users - Orphanage Management System</title>
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

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"],
        .form-container select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
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

        .user-list {
            margin: 20px 0;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .user-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-list th,
        .user-list td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .user-list th {
            background-color: #f4f4f4;
        }

        .user-list tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .user-list tbody tr:hover {
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
            background: url('../img/133781083_10258336.jpg') no-repeat center center fixed;
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

        <div class="form-container">
        <h2>Manage Users</h2>
            <h3><?php echo $editUser ? 'Edit User' : 'Add User'; ?></h3>
            <form id="user-form" action="manage_users.php" method="post" onsubmit="return validateForm();">
                <?php if ($editUser): ?>
                    <input type="hidden" name="user_id" value="<?php echo $editUser['user_id']; ?>">
                <?php endif; ?>
                <input type="text" id="username" name="username" placeholder="Username" value="<?php echo $editUser['username'] ?? ''; ?>" >
                <input type="email" id="email" name="email" placeholder="Email" value="<?php echo $editUser['email'] ?? ''; ?>" >
                <?php if (!$editUser): ?>
                    <input type="password" id="password" name="password" placeholder="Password" >
                <?php endif; ?>
                <select name="role" id="role" >
                    <option value="Admin" <?php echo isset($editUser) && $editUser['role'] == 'Admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="Staff" <?php echo isset($editUser) && $editUser['role'] == 'Staff' ? 'selected' : ''; ?>>Staff</option>
                    <option value="Medical" <?php echo isset($editUser) && $editUser['role'] == 'Medical' ? 'selected' : ''; ?>>Medical</option>
                    <option value="Educational" <?php echo isset($editUser) && $editUser['role'] == 'Educational' ? 'selected' : ''; ?>>Educational</option>
                </select>
                <input type="submit" name="<?php echo $editUser ? 'edit_user' : 'add_user'; ?>" value="<?php echo $editUser ? 'Edit User' : 'Add User'; ?>">
            </form>
        </div>

        <div class="user-list">
            <h3>Existing Users</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['user_id']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['role']; ?></td>
                            <td>
                                <form action="manage_users.php" method="get" style="display:inline;">
                                    <input type="hidden" name="edit_user_id" value="<?php echo $row['user_id']; ?>">
                                    <input type="submit" value="Edit" class="edit-button">
                                </form>
                                <form action="manage_users.php" method="post" style="display:inline;">
                                    <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                    <input type="submit" name="delete_user" value="Delete" class="delete-button" onclick="return confirm('Are you sure you want to delete this user?');">
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
            var username = document.getElementById('username').value.trim();
            var email = document.getElementById('email').value.trim();
            var password = document.getElementById('password');
            var role = document.getElementById('role').value;

            if (username === '') {
                alert('Username is required.');
                return false;
            }

            if (email === '') {
                alert('Email is required.');
                return false;
            }

            if (password && password.value.trim() === '') {
                alert('Password is required.');
                return false;
            }

            if (role === '') {
                alert('Role is required.');
                return false;
            }

            return true;
        }
    </script>
    <?php include('footer.php'); ?>
</body>
</html>
