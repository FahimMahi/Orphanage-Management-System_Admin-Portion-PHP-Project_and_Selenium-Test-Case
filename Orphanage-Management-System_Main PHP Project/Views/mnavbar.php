<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .navbar {
            width: 100%;
            background-color: #333;
            overflow: hidden;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            padding: 14px 20px;
            display: block;
            text-align: center;
        }

        .navbar a:hover {
            background-color: #575757;
            border-radius: 5px;
        }

        .navbar .navbar-brand a {
            font-size: 17.5px;
            font-weight: bold;
            text-decoration: none;
            color: #fff;
        }

        .navbar .navbar-brand a:hover {
            background-color: inherit; /* Ensure no background change on hover */
        }

        .navbar .navbar-links {
            display: flex;
        }

        .navbar .navbar-links a {
            margin-left: 10px;
            font-size: 13.5px;
        }

        .content {
            margin-top: 60px; /* Adjust based on navbar height */
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-brand">
            <a href="home.php">Orphanage Management System</a>
        </div>
        <div class="navbar-links">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="home.php">Home</a>
                <a href="Views/admin_dashboard.php" class="nav-link">Dashboard</a>
                <a href="Views/manage_users.php" class="nav-link">Manage Users</a>
                <a href="Views/child_records.php" class="nav-link">Child Records</a>
                <a href="Views/health_records.php" class="nav-link">Health Records</a>
                <a href="Views/educational_management.php" class="nav-link">Educational Management</a>
                <a href="Views/generate_reports.php" class="nav-link">Generate Reports</a>
                <a href="Views/messages.php" class="nav-link">Messages</a>
                <a href="Views/staff_child_management.php" class="nav-link">Staff Child Management</a>
                <a href="Views/manage_adoptions.php" class="nav-link">Manage Adoptions</a>
                <a href="Controllers/logout.php" class="nav-link">Logout</a>

                <a href="" class="nav-link"></a>
            <?php else: ?>
                <a href="home.php">Home</a>
                <a href="Views/login.php">Login</a>

                <a href="#" class="nav-link"></a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
