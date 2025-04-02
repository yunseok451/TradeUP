<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $message = $_POST['message'];
    $user_id = $_SESSION['user_id'] ?? NULL;

    try {
        // 데이터베이스 연결
        $pdo = new PDO('mysql:host=localhost;dbname=tradeup', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 1:1 문의 저장
        $stmt = $pdo->prepare("INSERT INTO inquiries (user_id, title, message) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $title, $message]);

        $success_message = "Your inquiry has been submitted successfully.";
    } catch (PDOException $e) {
        $error_message = "Database Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>1:1 Inquiry - TradeUp</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <div class="main-container">
            <h1>1:1 Inquiry</h1>
            <?php if (!empty($success_message)): ?>
                <p style="color: green;"><?= htmlspecialchars($success_message) ?></p>
            <?php elseif (!empty($error_message)): ?>
                <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
            <?php endif; ?>

            <form action="inquiry.php" method="POST" class="inquiry-form">
                <div>
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div>
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Inquiry</button>
            </form>
        </div>
    </main>

    <style>
        .main-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .inquiry-form div {
            margin-bottom: 15px;
        }
        .inquiry-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .inquiry-form input, .inquiry-form textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</body>
</html>
