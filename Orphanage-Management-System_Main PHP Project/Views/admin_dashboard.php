<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header("Location: login.php");
    exit();
}

include('../Models/config.php');

$stmt = $conn->prepare("SELECT username FROM Users WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();
include('navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Admin Dashboard - Orphanage Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #fff;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .dashboard-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .dashboard-container .username {
            font-size: 1.2em;
            color: #555;
            margin-bottom: 20px;
        }

        .dashboard-container .nav-link {
            display: block;
            margin: 10px 0;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .dashboard-container .nav-link:hover {
            background-color: #218838;
        }

        .logout-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .logout-link:hover {
            background-color: #c82333;
        }
        body {
            font-family: Arial, sans-serif;
            background: url('../img/2304.q894.007.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Admin Dashboard</h2>
        <div class="username">Welcome, <?php echo htmlspecialchars($username); ?>! 👋 </div>
        <a href="manage_users.php" class="nav-link">Manage Users</a>
        <a href="child_records.php" class="nav-link">Child Records</a>
        <a href="health_records.php" class="nav-link">Health Records</a>
        <a href="educational_management.php" class="nav-link">Educational Management</a>
        <a href="generate_reports.php" class="nav-link">Generate Reports</a>
        <a href="messages.php" class="nav-link">Messages</a>
        <a href="staff_child_management.php" class="nav-link">Staff Child Management</a>
        <a href="manage_adoptions.php" class="nav-link">Manage Adoptions</a>
        <a href="../Controllers/logout.php" class="logout-link">Logout</a>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>
