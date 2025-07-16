<?php
require_once __DIR__ . '/../config/db.php';
session_start();

$action = $_POST['action'] ?? '';

if ($action === 'create') {
    $email = $_POST['email'];
    $plainPassword = $_POST['password'];

    // 1. Check for duplicate email
    $stmt = $pdo->prepare("SELECT id FROM admins WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $_SESSION['admin_error'] = 'Email already exists.';
        header('Location: ../views/admin_create.php');
        exit;
    }

    // 2. Hash and insert
    $hash = password_hash($plainPassword, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO admins (email, password) VALUES (?, ?)");
    $stmt->execute([$email, $hash]);

    $_SESSION['admin_success'] = 'Admin created successfully.';
    header('Location: ../views/login.php');
    exit;
}
