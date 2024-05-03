<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, password_hash, role FROM Users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $password_db, $role);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && $password === $password_db && $role == 'Admin') {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['role'] = $role;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $login_error = "Invalid email, password, or you are not an admin";
    }

    $stmt->close();
}
?>
