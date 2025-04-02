<?php
session_start();

// Check if the user is an admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Get table name from URL parameter
$table = isset($_GET['table']) ? $_GET['table'] : 'sneakers';

try {
    // Connect to the database
    $pdo = new PDO('mysql:host=localhost;dbname=tradeup', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch product details
    if (isset($_GET['id'])) {
        $stmt = $pdo->prepare("SELECT * FROM $table WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            header('Location: admin_dashboard.php');
            exit();
        }
    }

    // Update product details
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $image = $_POST['image'];
        $table = $_POST['table']; // Ensure the table is also sent in the POST request

        $stmt = $pdo->prepare("UPDATE $table SET name = ?, price = ?, image = ? WHERE id = ?");
        $stmt->execute([$name, $price, $image, $id]);

        header('Location: admin_dashboard.php?table=' . $table);
        exit();
    }
} catch (PDOException $e) {
    $error_message = "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="main-container">
            <h1>Edit Product</h1>
            <?php if (!empty($error_message)): ?>
                <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
            <?php endif; ?>
            <form action="edit_product.php" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">
                <input type="hidden" name="table" value="<?= htmlspecialchars($table) ?>">
                <div class="form-group">
                    <label for="name">Product Name:</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="price">Price (₩):</label>
                    <input type="number" id="price" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="image">Image URL:</label>
                    <input type="text" id="image" name="image" value="<?= htmlspecialchars($product['image']) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Product</button>
            </form>
        </div>
    </main>
</body>
</html>
