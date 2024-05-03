<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('../Models/config.php');
include('../Controllers/messages_controllers.php');

include('navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Messages - Orphanage Management System</title>
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

        .message-section {
            background-color: #fff;
            margin: 20px 0;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .message-section h3 {
            margin-top: 0;
            color: #333;
        }

        .message-form {
            margin-bottom: 20px;
        }

        .message-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .message-form select,
        .message-form textarea,
        .message-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .message-list {
            margin-top: 20px;
        }

        .message-list table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
        }

        .message-list th,
        .message-list td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .message-list th {
            background-color: #f4f4f4;
            color: #333;
        }

        .message-list tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .message-list tbody tr:hover {
            background-color: #f1f1f1;
        }
        body {
            font-family: Arial, sans-serif;
            background: url('../img/7368759_3612880.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">

        <div class="message-section">
        <h2>Messages</h2>
            <h3>Send a Message</h3>
            <form class="message-form" action="messages.php" method="post" onsubmit="return validateForm();">
                <label for="receiver_id">To:</label>
                <select name="receiver_id" id="receiver_id" required>
                    <option value="">Select User</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user['user_id']; ?>"><?php echo $user['username']; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="message_text">Message:</label>
                <textarea name="message_text" id="message_text" rows="4" required></textarea>

                <input type="submit" name="send_message" value="Send Message">
            </form>
        </div>

        <div class="message-section">
            <h3>Inbox</h3>
            <div class="message-list">
                <table>
                    <thead>
                        <tr>
                            <th>Message ID</th>
                            <th>From</th>
                            <th>Message</th>
                            <th>Sent At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $messagesResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['message_id']; ?></td>
                                <td><?php echo $row['sender_username']; ?></td>
                                <td><?php echo $row['message_text']; ?></td>
                                <td><?php echo $row['sent_at']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php if ($statusMessage): ?>
        <script>
            alert('<?php echo $statusMessage; ?>');
        </script>
    <?php endif; ?>

    <script>
        function validateForm() {
            var receiverId = document.getElementById('receiver_id').value.trim();
            var messageText = document.getElementById('message_text').value.trim();

            if (receiverId === '') {
                alert('Receiver is required.');
                return false;
            }

            if (messageText === '') {
                alert('Message is required.');
                return false;
            }

            return true;
        }
    </script>
    <?php include('footer.php'); ?>
</body>
</html>
