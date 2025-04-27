<?php
session_start();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['role'] = $user['role']; // 👈 Store role in session

        // 👇 Redirect based on role
        if ($user['role'] === 'admin') {
            header("Location: admin/index.php");
        } else {
            header("Location: user/index.php");
        }
        exit();
    } else {
        $_SESSION['error'] = "Invalid Username or Password";
        header("Location: login.php");
        exit();
    }
}
?>
