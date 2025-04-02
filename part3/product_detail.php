<?php
// product_detail.php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail - TradeUp</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="main-container">
            <?php
            // Check if id and table are set in the URL
            if (isset($_GET['id']) && isset($_GET['table'])) {
                $productId = intval($_GET['id']); // Ensure ID is an integer
                $table = $_GET['table'];

                // List of allowed table names
                $validTables = ['sneakers', 'clothing', 'accessories', 'tech', 'lifestyle'];

                // Validate the table name
                if (!in_array($table, $validTables)) {
                    echo "<p>Error: Invalid table specified.</p>";
                    exit();
                }

                try {
                    // Connect to the database
                    $pdo = new PDO('mysql:host=localhost;dbname=tradeup', 'root', '');
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Fetch product details from the specified table
                    $stmt = $pdo->prepare("SELECT name, price, image, description FROM $table WHERE id = ?");
                    $stmt->execute([$productId]);
                    $product = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($product) {
                        echo "<div class='product-detail'>";
                        echo "<img src='" . htmlspecialchars($product['image']) . "' alt='" . htmlspecialchars($product['name']) . "'>";
                        echo "<div class='product-info'>";
                        echo "<h1>" . htmlspecialchars($product['name']) . "</h1>";
                        echo "<p class='price'>₩" . number_format($product['price']) . "</p>";
                        echo "<p class='description'>" . htmlspecialchars($product['description']) . "</p>";

                        // "Add to Cart" and "Buy Now" buttons
                        echo "<div class='button-group'>";
                        echo "<form action='cart_handler.php' method='POST'>";
                        echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($productId) . "'>";
                        echo "<input type='hidden' name='table' value='" . htmlspecialchars($table) . "'>";
                        echo "<input type='hidden' name='action' value='add_to_cart'>";
                        echo "<button type='submit' class='btn'>Add to Cart</button>";
                        echo "</form>";

                        echo "<form action='order_handler.php' method='POST'>";
                        echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($productId) . "'>";
                        echo "<input type='hidden' name='table' value='" . htmlspecialchars($table) . "'>";
                        echo "<input type='hidden' name='action' value='buy_now'>";
                        echo "<button type='submit' class='btn btn-primary'>Buy Now</button>";
                        echo "</form>";
                        echo "</div>"; // .button-group
                        echo "</div>"; // .product-info
                        echo "</div>"; // .product-detail
                    } else {
                        echo "<p>Product not found in table $table for ID $productId.</p>";
                    }
                } catch (PDOException $e) {
                    echo "<p>Error: " . $e->getMessage() . "</p>";
                }
            } else {
                echo "<p>Invalid product ID or table specified.</p>";
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
        .product-detail {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }
        .product-detail img {
            max-width: 300px;
            height: auto;
            border-radius: 10px;
        }
        .product-info {
            flex: 1;
        }
        .product-info h1 {
            margin-top: 0;
            font-size: 28px;
        }
        .product-info .price {
            color: #007BFF;
            font-size: 22px;
            margin: 10px 0;
        }
        .product-info .description {
            font-size: 16px;
            color: #555;
            margin: 20px 0;
        }
        .button-group {
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            background-color: #ddd;
            color: black;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #bbb;
        }
        .btn-primary {
            background-color: #007BFF;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</body>
</html>