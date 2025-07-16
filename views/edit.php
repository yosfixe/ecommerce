<?php
require_once '../config/auth.php';
require_once '../config/db.php';

// 1. Get product by ID
if (!isset($_GET['id'])) {
    header('Location: list.php');
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    echo "Product not found.";
    exit;
}

// 2. Get categories for dropdown
$cats = $pdo->query("SELECT id, name FROM categories ORDER BY name")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Product</title>
</head>
<body>
  <h2>Edit Product</h2>

  <form action="../controllers/product_controller.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="action" value="update">
    <input type="hidden" name="id" value="<?= $product['id'] ?>">

    <!-- Category Dropdown -->
    <label>Category:</label><br>
    <select name="category_id" required>
      <option value="">-- Select Category --</option>
      <?php foreach ($cats as $cat): ?>
        <option value="<?= $cat['id'] ?>" 
          <?= ($cat['id'] == $product['category_id']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($cat['name']) ?>
        </option>
      <?php endforeach; ?>
    </select><br><br>

    <label>Name:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required><br><br>

    <label>Price:</label><br>
    <input type="number" name="price" value="<?= $product['price'] ?>" step="0.01" required><br><br>

    <label>Description:</label><br>
    <textarea name="description" rows="3"><?= htmlspecialchars($product['description']) ?></textarea><br><br>

    <label>Current Image:</label><br>
    <?php if ($product['image']): ?>
      <img src="../uploads/<?= $product['image'] ?>" width="100"><br>
    <?php else: ?>
      No image<br>
    <?php endif; ?>

    <label>Change Image:</label><br>
    <input type="file" name="image"><br><br>

    <button type="submit">Update Product</button>
    <a href="list.php">Cancel</a>
  </form>
</body>
</html>
