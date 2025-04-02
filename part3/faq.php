<?php
session_start();

try {
    // 데이터베이스 연결
    $pdo = new PDO('mysql:host=localhost;dbname=tradeup', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // FAQ 데이터 가져오기
    $stmt = $pdo->query("SELECT question, answer FROM faq");
    $faqs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - TradeUp</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="main-container">
            <h1>Frequently Asked Questions</h1>
            <div class="faq-section">
                <?php foreach ($faqs as $faq): ?>
                    <div class="faq-item">
                        <h3><?= htmlspecialchars($faq['question']) ?></h3>
                        <p><?= nl2br(htmlspecialchars($faq['answer'])) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <style>
        .main-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .faq-section {
            margin-top: 20px;
        }
        .faq-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .faq-item h3 {
            margin: 0 0 5px;
        }
        .faq-item p {
            margin: 0;
            color: #555;
        }
    </style>
</body>
</html>
