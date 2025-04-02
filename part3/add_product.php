<?php
session_start();

// Check if the user is an admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $allowedTables = ['sneakers', 'clothing', 'accessories', 'tech', 'lifestyle']; // 허용된 테이블 목록
    $table = $_POST['table'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $description = $_POST['description'];

    try {
        // Connect to the database
        $pdo = new PDO('mysql:host=localhost;dbname=tradeup', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert the product into the selected table
        $query = "INSERT INTO $table (name, price, image, description) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$name, $price, $image, $description]);

        header('Location: admin_dashboard.php');
        exit();
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="main-container">
            <h1>Add New Product</h1>
            <?php if (!empty($error_message)): ?>
                <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
            <?php endif; ?>
            <form action="add_product.php" method="POST">
                <div class="form-group">
                    <label for="table">Select Table:</label>
                    <select id="table" name="table" required>
                        <option value="sneakers">Sneakers</option>
                        <option value="clothing">Clothing</option>
                        <option value="accessories">Accessories</option>
                        <option value="tech">Tech</option>
                        <option value="lifestyle">Lifestyle</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">Product Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="price">Price (₩):</label>
                    <input type="number" id="price" name="price" required>
                </div>
                <div class="form-group">
                    <label for="image">Image URL:</label>
                    <input type="text" id="image" name="image" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add Product</button>
            </form>
        </div>
    </main>

    <style>
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        textarea {
            resize: vertical;
        }
        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</body>
</html>
