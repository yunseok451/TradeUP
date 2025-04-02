<?php
// order_confirmation.php
session_start();

if (!isset($_SESSION['order']['id']) || !isset($_SESSION['order']['table'])) {
    header('Location: index.php');
    exit();
}

$orderProductId = $_SESSION['order']['id'];
$table = $_SESSION['order']['table'];

try {
    // Connect to the database
    $pdo = new PDO('mysql:host=localhost;dbname=tradeup', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch product details from the specified table
    $stmt = $pdo->prepare("SELECT name, price, image FROM $table WHERE id = ?");
    $stmt->execute([$orderProductId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo "<p>Product not found.</p>";
        exit();
    }
} catch (PDOException $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - TradeUp</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="main-container">
            <h1>Order Confirmation</h1>
            <div class="order-summary">
                <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                <h2><?= htmlspecialchars($product['name']) ?></h2>
                <p class="price">₩<?= number_format($product['price']) ?></p>
                <p>Thank you for your order! Your product will be shipped soon.</p>
                <a href="index.php" class="btn">Return to Home</a>
            </div>
        </div>
    </main>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .main-container {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }
        .order-summary {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .order-summary img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .order-summary h2 {
            margin: 20px 0;
            font-size: 24px;
        }
        .order-summary .price {
            color: #007BFF;
            font-size: 20px;
            margin: 10px 0;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</body>
</html>
