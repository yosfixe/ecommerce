<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>eCommerce Admin</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 600px; margin: 40px auto; }
    ul { list-style:none; padding:0; }
    li { margin: 10px 0; }
    a.button {
      display: inline-block;
      padding: 8px 16px;
      background: #28a745;
      color: #fff;
      text-decoration: none;
      border-radius: 4px;
    }
    a.button:hover { background: #218838; }
    form { margin-top: 20px; }
    input[type="number"] { width: 80px; }
  </style>
</head>
<body>

  <h1>Welcome to eCommerce Admin</h1>

  <ul>
    <li><a href="views/create.php" class="button"> Add New Product</a></li>
    <li><a href="views/list.php"  class="button"> View Product List</a></li>
  </ul>

  <form action="views/edit.php" method="get">
    <label for="id">Edit Product (by ID):</label>
    <input type="number" name="id" id="id" min="1" required>
    <button type="submit" class="button" style="background:#ffc107;color:#212529;"> Edit</button>
  </form>

</body>
</html>
