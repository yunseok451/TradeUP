<?php
session_start();

try {
    // 데이터베이스 연결
    $pdo = new PDO('mysql:host=localhost;dbname=tradeup', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 발매 일정 데이터 가져오기
    $stmt = $pdo->query("SELECT product_name, release_date, category, image, description FROM release_schedule ORDER BY release_date ASC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Release Schedule - TradeUp</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="main-container">
            <h1>Upcoming Releases</h1>
            <table class="release-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Release Date</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image" class="release-image"></td>
                            <td><?= htmlspecialchars($product['product_name']) ?></td>
                            <td><?= htmlspecialchars($product['category']) ?></td>
                            <td><?= htmlspecialchars($product['release_date']) ?></td>
                            <td><?= htmlspecialchars($product['description']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <style>
        .main-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .release-table {
            width: 100%;
            border-collapse: collapse;
        }
        .release-table th, .release-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .release-table th {
            background-color: #f4f4f4;
        }
        .release-image {
            width: 80px;
            height: auto;
            border-radius: 5px;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</body>
</html>
