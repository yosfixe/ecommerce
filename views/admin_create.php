<?php
require_once __DIR__ . '/../config/auth.php'; // Ensure only logged-in admins can access

// Handle session messages
session_start();
$error   = $_SESSION['admin_error'] ?? '';
$success = $_SESSION['admin_success'] ?? '';
unset($_SESSION['admin_error'], $_SESSION['admin_success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create New Admin</title>
  <style>
    body { font-family: Arial; max-width: 500px; margin: 50px auto; }
    label { font-weight: bold; display: block; margin-top: 10px; }
    input[type="email"],
    input[type="password"] {
      width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box;
    }
    button {
      margin-top: 20px;
      padding: 10px 20px;
      background: #28a745;
      color: #fff;
      border: none;
      cursor: pointer;
    }
    a { display: inline-block; margin-top: 15px; text-decoration: none; color: #007bff; }
    .message { margin-top: 15px; }
    .error   { color: red; }
    .success { color: green; }
  </style>
</head>
<body>

  <h2>Create New Admin</h2>

  <?php if ($error): ?>
    <div class="message error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="message success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <form action="../controllers/admin_controller.php" method="POST">
    <input type="hidden" name="action" value="create">

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>Confirm Password</label>
    <input type="password" name="confirm_password" required>

    <button type="submit">Create Admin</button>
  </form>

  <a href="list.php">← Back to Product List</a>

</body>
</html>
