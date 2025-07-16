<?php
require_once __DIR__ . '/../config/auth.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../views/login.php');
    exit;
}
?>
<h2>Add New Product</h2>
<form action="../controllers/product_controller.php" method="POST" enctype="multipart/form-data" class="row g-3">
  <label>Category:</label><br>
<select name="category_id" required>
  <option value="">-- Select Category --</option>
  <?php foreach ($categories as $cat): ?>
    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
  <?php endforeach; ?>
</select><br><br>

  <input type="hidden" name="action" value="create">
  <div class="col-md-6">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Price ($)</label>
    <input type="number" name="price" class="form-control" step="0.01" required>
  </div>
  <div class="col-12">
    <label class="form-label">Description</label>
    <?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/db.php';

// Fetch categories to show in dropdown
$stmt = $pdo->query("SELECT id, name FROM categories ORDER BY name ASC");
$categories = $stmt->fetchAll();
?>

    <textarea name="description" class="form-control" rows="3"></textarea>
  </div>
  <div class="col-12">
    <label class="form-label">Image</label>
    <input type="file" name="image" class="form-control">
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-success">Save Product</button>
    <a href="list.php" class="btn btn-secondary">Cancel</a>
  </div>
</form>
