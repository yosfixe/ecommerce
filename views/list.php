<?php
require_once '../config/db.php';
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Product List</h2>
<table class="table table-striped table-hover">
  <thead class="table-primary">
    <tr>
      <th>Name</th>
      <th>Price</th>
      <th>Description</th>
      <th>Image</th>
      <th>Created</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php if (count($products)): ?>
      <?php foreach ($products as $p): ?>
        <tr>
          <td><?= htmlspecialchars($p['name']) ?></td>
          <td><?= number_format($p['price'],2) ?></td>
          <td><?= htmlspecialchars($p['description']) ?></td>
          <td>
            <?php if ($p['image']): ?>
              <img src="../uploads/<?= $p['image'] ?>" class="img-thumbnail" style="max-width:80px">
            <?php else: ?>
              —
            <?php endif; ?>
          </td>
          <td><?= $p['created_at'] ?></td>
          <td>
            <a href="edit.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="../controllers/product_controller.php?action=delete&id=<?= $p['id'] ?>"
               class="btn btn-sm btn-danger"
               onclick="return confirm('Delete this product?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="6" class="text-center">No products yet.</td></tr>
    <?php endif; ?>
  </tbody>
</table>
