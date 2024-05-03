<?php
// for the dropdown
$usersResult = $conn->query("SELECT user_id, username FROM Users WHERE user_id != " . $_SESSION['user_id']);
$users = [];
while ($row = $usersResult->fetch_assoc()) {
    $users[] = $row;
}

$statusMessage = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['send_message'])) {
        $receiver_id = $_POST['receiver_id'];
        $message_text = $_POST['message_text'];

        $stmt = $conn->prepare("INSERT INTO Messages (sender_id, receiver_id, message_text, sent_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iis", $_SESSION['user_id'], $receiver_id, $message_text);
        if ($stmt->execute()) {
            $statusMessage = 'Message sent successfully';
        } else {
            $statusMessage = 'Failed to send message';
        }
        $stmt->close();
    }
}

$messagesResult = $conn->query("
    SELECT m.message_id, m.sender_id, m.receiver_id, m.message_text, m.sent_at, u.username AS sender_username
    FROM Messages m
    JOIN Users u ON m.sender_id = u.user_id
    WHERE m.receiver_id = " . $_SESSION['user_id'] . "
    ORDER BY m.sent_at DESC
");

?>
