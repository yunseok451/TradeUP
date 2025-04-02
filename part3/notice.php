<?php
session_start();

// 정적 공지사항 데이터
$notices = [
    [
        'title' => 'TradeUp 2024 업데이트 안내',
        'content' => '2024년 새롭게 업데이트된 기능들을 소개합니다. 더 나은 서비스를 제공하기 위해 항상 노력하겠습니다.',
        'created_at' => '2024-06-01'
    ],
    [
        'title' => '긴급 서버 점검 공지',
        'content' => '2024년 6월 15일 새벽 2시부터 4시까지 서버 점검이 예정되어 있습니다. 서비스 이용에 참고해주시기 바랍니다.',
        'created_at' => '2024-06-05'
    ],
    [
        'title' => '신규 이벤트 참여 안내',
        'content' => '6월 한 달 동안 다양한 이벤트가 준비되어 있습니다. 많은 참여 부탁드립니다!',
        'created_at' => '2024-06-10'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notices - TradeUp</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="main-container">
            <h1>Notices</h1>
            <div class="notice-list">
                <?php foreach ($notices as $notice): ?>
                    <div class="notice-item">
                        <h3><?= htmlspecialchars($notice['title']) ?></h3>
                        <p><?= nl2br(htmlspecialchars($notice['content'])) ?></p>
                        <small>Posted on: <?= htmlspecialchars($notice['created_at']) ?></small>
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
        .notice-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .notice-item {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .notice-item h3 {
            margin: 0 0 10px;
            color: #333;
        }
        .notice-item p {
            margin: 0 0 10px;
            color: #555;
        }
        .notice-item small {
            display: block;
            color: #888;
            text-align: right;
        }
    </style>
</body>
</html>
