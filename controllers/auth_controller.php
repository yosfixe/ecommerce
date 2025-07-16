<?php
session_start();
require_once __DIR__ . '/../config/db.php';

$action = $_REQUEST['action'] ?? '';

if ($action == 'login' & $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Lookup admin
    $stmt = $pdo->prepare("SELECT id, password FROM admins WHERE email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        // Successful login
        $_SESSION['admin_id'] = $admin['id'];
        header('Location: ../views/list.php');
        exit;
    } else {
        // Failed
        $_SESSION['auth_error'] = 'Invalid email or password.';
        header('Location: ../views/login.php');
        exit;
    }
}

if ($action === 'logout') {
    session_unset();
    session_destroy();
    header('Location: ../views/login.php');
    exit;
}

// If we get here, unknown action
http_response_code(400);
echo 'Bad request';
