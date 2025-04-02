<?php
session_start();

try {
    // 데이터베이스 연결
    $pdo = new PDO('mysql:host=localhost;dbname=tradeup', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 사용자 닉네임 불러오기
    $author = 'Guest';
    if (isset($_SESSION['user_id'])) {
        $stmt = $pdo->prepare("SELECT nickname FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && !empty($result['nickname'])) {
            $author = $result['nickname'];
        }
    }

    // 게시글 저장 처리
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $content = $_POST['content'];

        $stmt = $pdo->prepare("INSERT INTO community_posts (title, content, author) VALUES (?, ?, ?)");
        $stmt->execute([$title, $content, $author]);

        header("Location: community.php");
        exit();
    }

    // 게시글 조회
    $stmt = $pdo->query("SELECT * FROM community_posts ORDER BY created_at DESC");
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community - TradeUp</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="main-container">
            <h1>Community Board</h1>

            <!-- 게시글 작성 폼 -->
            <form action="community.php" method="POST" class="post-form">
                <div>
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div>
                    <label for="content">Content</label>
                    <textarea id="content" name="content" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Post</button>
            </form>

            <!-- 게시글 목록 -->
            <div class="posts">
                <?php foreach ($posts as $post): ?>
                    <div class="post">
                        <h3><?= htmlspecialchars($post['title']) ?></h3>
                        <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                        <small>By <?= htmlspecialchars($post['author']) ?> | <?= $post['created_at'] ?></small>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .main-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .post-form {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .post-form div {
            margin-bottom: 10px;
        }
        .post-form label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .post-form input, .post-form textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .posts {
            border-top: 1px solid #ddd;
            margin-top: 20px;
        }
        .post {
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }
        .post h3 {
            margin: 0 0 10px;
        }
        .post p {
            margin: 0 0 10px;
        }
        .post small {
            color: #666;
            font-size: 12px;
        }
    </style>
</body>
</html>
