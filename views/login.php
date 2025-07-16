<?php
session_start();
// ef already logged in, redirect to product list
if (isset($_SESSION['admin_id'])) {
    header('Location: views/list.php');
    exit;
}

// show any errror message
$error = $_SESSION['auth_error'] ?? '';
unset($_SESSION['auth_error']);
?>
<?php
// Get the email & password from the login form
$email = $_POST['email'];
$password = $_POST['password'];

// Fetch the admin record
$stmt = $pdo->prepare("SELECT id, password FROM admins WHERE email = ?");
$stmt->execute([$email]);
$admin = $stmt->fetch();

if ($admin && password_verify($password, $admin['password'])) {
    // Password is correct → log them in
    $_SESSION['admin_id'] = $admin['id'];
    header('Location: ../views/list.php');
    exit;
} else {
    // Invalid credentials
    $_SESSION['auth_error'] = 'Invalid email or password';
    header('Location: ../views/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 360px; margin: 80px auto; }
    form { display: flex; flex-direction: column; }
    label { margin-top: 10px; }
    input { padding: 8px; font-size: 1em; }
    button { margin-top: 20px; padding: 10px; background: #007bff; color: #fff; border: none; }
    .error { color: red; margin-bottom: 10px; }
  </style>
</head>
<body>
  <h2>Admin Login</h2>
  <?php if ($error): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form action="../controllers/auth_controller.php" method="post">
    <input type="hidden" name="action" value="login">
    <label for="email">Email</label>
    <input id="email" type="email" name="email" required autofocus>
    <label for="pw">Password</label>
    <input id="pw" type="password" name="password" required>
    <button type="submit">Log In</button>
  </form>
</body>
</html>
