<?php
// signup.php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];
    $name = $_POST['name'];
    $nickname = $_POST['nickname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($password !== $confirmPassword) {
        $error_message = 'Passwords do not match.';
    } else {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=tradeup', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare('INSERT INTO users (userId, name, nickname, email, password) VALUES (?, ?, ?, ?, ?)');
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->execute([$userId, $name, $nickname, $email, $hashedPassword]);

            $_SESSION['userId'] = $userId;
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            $error_message = 'Error: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - TradeUp</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="signup-container">
            <h1>Create Your Account</h1>
            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?= htmlspecialchars($error_message) ?></p>
            <?php endif; ?>
            <form action="signup.php" method="POST">
                <div class="form-group">
                    <label for="userId">User ID</label>
                    <input type="text" id="userId" name="userId" required placeholder="Enter your user ID">
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required placeholder="Enter your name">
                </div>
                <div class="form-group">
                    <label for="nickname">Nickname</label>
                    <input type="text" id="nickname" name="nickname" required placeholder="Enter your nickname">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required placeholder="Confirm your password">
                </div>
                <button type="submit">Sign Up</button>
            </form>
            <p>Already have an account? <a href="login.php">Log in</a></p>
        </div>
    </main>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(120deg, #f0f0f0, #e8e8e8);
        }
        .signup-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 14px;
            color: #555555;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #dddddd;
            border-radius: 8px;
            font-size: 14px;
            box-sizing: border-box;
        }
        input:focus {
            border-color: #007BFF;
            outline: none;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 15px;
        }
        p {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #555555;
        }
        p a {
            color: #007BFF;
            text-decoration: none;
        }
        p a:hover {
            text-decoration: underline;
        }
    </style>
</body>
</html>
