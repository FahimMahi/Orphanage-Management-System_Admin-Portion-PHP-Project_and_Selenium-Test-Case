<?php
session_start();

include('../Models/config.php');

include('../Controllers/logincontroller.php');
include('navbar.php');

if (isset($_SESSION['user_id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Login - Orphanage Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .login-container .error {
            color: #dc3545;
            margin-bottom: 20px;
        }

        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .login-container input[type="submit"] {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        .login-container input[type="submit"]:hover {
            background-color: #218838;
        }
        body {
            font-family: Arial, sans-serif;
            background: url('../img/2304_q894_004.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($login_error)): ?>
            <div class="error"><?php echo $login_error; ?></div>
        <?php endif; ?>
        <div id="error-message" class="error"></div>
        <form id="login-form" action="login.php" method="post">
            <input type="email" id="email" name="email" placeholder="Email" >
            <input type="password" id="password" name="password" placeholder="Password" >
            <input type="submit" value="Login">
        </form>
    </div>

    <script>
        document.getElementById('login-form').addEventListener('submit', function(event) {
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;

            if (email.trim() === '' && password.trim() === '') {
                alert('Both fields are required');
                event.preventDefault();
            } else if (email.trim() === '') {
                alert('Email is required');
                event.preventDefault();
            } else if (password.trim() === '') {
                alert('Password is required');
                event.preventDefault();
            }
        });
    </script>
    <?php include('footer.php'); ?>
</body>
</html>
