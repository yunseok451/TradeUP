<?php
// sneakers.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech - TradeUp</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="main-container">
            <h1>Tech</h1>
            <div class="product-grid">
                <?php
                try {
                    // Connect to the database
                    $pdo = new PDO('mysql:host=localhost;dbname=tradeup', 'root', '');
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Fetch products from the sneakers table
                    $stmt = $pdo->query('SELECT id, name, price, image FROM tech');
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<div class='product'>";
                        echo "<a href='product_detail.php?id=" . htmlspecialchars($row['id']) . "&table=tech'>";
                        echo "<img src='" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['name']) . "'>";
                        echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                        echo "<p>₩" . number_format($row['price']) . "</p>";
                        echo "</a>";
                        echo "</div>";
                    }
                } catch (PDOException $e) {
                    echo "<p>Error: " . $e->getMessage() . "</p>";
                }
                ?>
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
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
        }
        .product {
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px;
            background-color: #fff;
        }
        .product img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .product h3 {
            margin: 10px 0;
            font-size: 18px;
        }
        .product p {
            color: #555;
            font-size: 16px;
        }
        .product a {
            text-decoration: none;
            color: inherit;
        }
        .product a:hover {
            text-decoration: underline;
        }
    </style>
</body>
</html>
