<?php
// cart.php
session_start();

// Mock data for testing if no session data exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = []; // Ensure it's an empty array
}

try {
    // Connect to the database
    $pdo = new PDO('mysql:host=localhost;dbname=tradeup', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $products = [];

    // Check if cart is not empty before querying
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            // Validate table and id from the cart session
            if (isset($item['table']) && isset($item['id'])) {
                $table = $item['table'];
                $productId = intval($item['id']);

                // Fetch product details from the respective table
                $stmt = $pdo->prepare("SELECT id, name, price, image FROM $table WHERE id = ?");
                $stmt->execute([$productId]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($product) {
                    $product['table'] = $table; // Store table info for use in checkout or updates
                    $products[] = $product;
                }
            }
        }
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
    <title>Shopping Cart - TradeUp</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="main-container">
            <h1>Your Cart</h1>

            <?php if (!empty($products)): ?>
                <div class="cart-grid">
                    <?php foreach ($products as $product): ?>
                        <div class="cart-item">
                            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                            <h2><?= htmlspecialchars($product['name']) ?></h2>
                            <p class="price">₩<?= number_format($product['price']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="cart-summary">
                    <p>Total: ₩<?= number_format(array_sum(array_column($products, 'price'))) ?></p>
                    <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
                </div>
            <?php else: ?>
                <p>Your cart is empty.</p>
                <a href="index.php" class="btn">Continue Shopping</a>
            <?php endif; ?>
        </div>
    </main>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .main-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .cart-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        .cart-item {
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px;
            background-color: #fff;
        }
        .cart-item img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .cart-item h2 {
            margin: 10px 0;
            font-size: 18px;
        }
        .cart-item .price {
            color: #555;
            font-size: 16px;
        }
        .cart-summary {
            margin-top: 20px;
            text-align: center;
            font-size: 18px;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #ddd;
            color: black;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn-primary {
            background-color: #007BFF;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn:hover {
            background-color: #bbb;
        }
    </style>
</body>
</html>
