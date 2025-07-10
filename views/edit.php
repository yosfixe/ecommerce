<?php
require_once '../config/db.php';
if (!isset($_GET['id'])) header('Location:list.php');
$stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
$stmt->execute([$_GET['id']]);
$p = $stmt->fetch() ?: die('Not found');
?>
<h2>Edit Product</h2>
<form action="../controllers/product_controller.php" method="POST" enctype="multipart/form-data" class="row g-3">
  <input type="hidden" name="action" value="update">
  <input type="hidden" name="id" value="<?= $p['id'] ?>">
  <div class="col-md-6">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($p['name']) ?>" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Price ($)</label>
    <input type="number" name="price" class="form-control" step="0.01" value="<?= $p['price'] ?>" required>
  </div>
  <div class="col-12">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($p['description']) ?></textarea>
  </div>
  <div class="col-12">
    <label class="form-label">Current Image</label><br>
    <?php if ($p['image']): ?>
      <img src="../uploads/<?= $p['image'] ?>" class="img-thumbnail mb-2" style="max-width:120px">
    <?php else: ?>
      <span class="text-muted">None</span>
    <?php endif; ?>
    <label class="form-label mt-2">Change Image</label>
    <input type="file" name="image" class="form-control">
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="list.php" class="btn btn-secondary">Back</a>
  </div>
</form>
