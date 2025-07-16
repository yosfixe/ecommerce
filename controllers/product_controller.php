<?php
// UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // handle optional new image
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $uploadDir = '../uploads/';
        $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $imagePath = $imageName;
        }
    }
    $category_id = $_POST['category_id'] ?? null;

    $stmt = $pdo->prepare("INSERT INTO products (name, price, description, image, category_id, created_at)
                       VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$name, $price, $description, $imagePath, $category_id]);

    if ($imagePath) {
        $stmt = $pdo->prepare("UPDATE products SET name=?, price=?, description=?, image=? WHERE id=?");
        $stmt->execute([$name, $price, $description, $imagePath, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE products SET name=?, price=?, description=? WHERE id=?");
        $stmt->execute([$name, $price, $description, $id]);
    }

    header('Location: ../views/list.php');
    exit;
}

// DELETE
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: ../views/list.php');
    exit;
}
?>