<?php
include('Views/mnavbar.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Home - Orphanage Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('img/2304.q894.003.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        .content-container {
            margin-top: 60px; /* Adjusted for navbar height */
            padding: 20px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.8); /* Add a light background for readability */
            border: 1px solid #ddd; /* Add border */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            max-width: 900px; /* Limit max width */
            margin: 60px auto; /* Center the container */
        }

        .content-container h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .content-container p {
            color: #555;
            font-size: 18px;
            line-height: 1.6;
        }

        .features {
            margin-top: 40px;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .feature {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 10px;
            width: 300px;
            text-align: left;
        }

        .feature h3 {
            color: #333;
            margin-bottom: 15px;
        }

        .feature p {
            color: #555;
        }
    </style>
</head>
<body>
    <div class="content-container">
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <h1>Welcome to the Orphanage Management System</h1>
        <p>
            The Orphanage Management System is designed to streamline and manage the various operations of an orphanage.
            It helps in keeping track of child records, health records, educational management, and staff assignments,
            ensuring the best care and attention for every child.
        </p>
        <div class="features">
            <div class="feature">
                <h3>Manage Child Records</h3>
                <p>Keep detailed records of each child, including personal details, health, and educational progress.</p>
            </div>
            <div class="feature">
                <h3>Health Management</h3>
                <p>Track the medical history, vaccinations, and health checkups of children to ensure their well-being.</p>
            </div>
            <div class="feature">
                <h3>Educational Management</h3>
                <p>Manage educational records, including school details, grades, and extracurricular activities.</p>
            </div>
            <div class="feature">
                <h3>Staff Assignments</h3>
                <p>Assign staff to children for personalized care and manage staff responsibilities effectively.</p>
            </div>
            <div class="feature">
                <h3>Generate Reports</h3>
                <p>Generate detailed reports on various aspects of the orphanage's operations for better management and transparency.</p>
            </div>
        </div>
    </div>
    <?php include('Views/mfooter.php'); ?>
</body>
</html>
