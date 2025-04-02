<?php
// checkout.php
session_start();

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

try {
    // Connect to the database
    $pdo = new PDO('mysql:host=localhost;dbname=tradeup', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $products = [];
    $totalPrice = 0;

    // Check if cart is not empty before querying
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            if (isset($item['table']) && isset($item['id'])) {
                $table = $item['table'];
                $productId = intval($item['id']);

                // Fetch product details from the respective table
                $stmt = $pdo->prepare("SELECT id, name, price, image FROM $table WHERE id = ?");
                $stmt->execute([$productId]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($product) {
                    $product['table'] = $table; // Store table info for further use
                    $products[] = $product;
                    $totalPrice += $product['price'];
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
    <title>Checkout - TradeUp</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="main-container">
            <h1>Checkout</h1>

            <div class="checkout-summary">
                <h2>Order Summary</h2>
                <ul>
                    <?php foreach ($products as $product): ?>
                        <li>
                            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="checkout-image">
                            <span><?= htmlspecialchars($product['name']) ?></span>
                            <span>₩<?= number_format($product['price']) ?></span>
                            <form action="delete_item.php" method="POST" class="delete-form">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="table" value="<?= $product['table'] ?>">
                                <button type="submit" class="btn btn-delete">Delete</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <p class="total-price">Total: ₩<?= number_format($totalPrice) ?></p>
            </div>

            <form action="checkout.php" method="POST">
                <button type="submit" class="btn btn-primary">Place Order</button>
            </form>

            <?php
            // Handle form submission
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Clear the cart
                $_SESSION['cart'] = [];

                echo "<p class='success-message'>Order placed successfully! Thank you for your purchase.</p>";
            }
            ?>
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
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .checkout-summary ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .checkout-summary li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .checkout-image {
            max-width: 50px;
            height: auto;
            border-radius: 5px;
            margin-right: 10px;
        }
        .total-price {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }
        .btn {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #ddd;
            color: black;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }
        .btn-primary {
            background-color: #007BFF;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-delete {
            background-color: #FF6347;
            color: white;
        }
        .btn-delete:hover {
            background-color: #cc281e;
        }
        .success-message {
            margin-top: 20px;
            text-align: center;
            font-size: 18px;
            color: green;
            font-weight: bold;
        }
        .delete-form {
            margin-left: 10px;
        }
    </style>
</body>
</html>
