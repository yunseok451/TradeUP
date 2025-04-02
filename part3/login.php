<?php
// login.php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];
    $password = $_POST['password'];

    try {
        // Connect to the database
        $pdo = new PDO('mysql:host=localhost;dbname=tradeup', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch user data
        $stmt = $pdo->prepare('SELECT * FROM users WHERE userId = ?');
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Validate credentials
        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['userId'] = $user['userId'];
            $_SESSION['nickname'] = $user['nickname'];
            $_SESSION['user_role'] = $user['role']; // 'admin' or 'user'

            // Redirect to homepage or admin dashboard
            if ($user['role'] === 'admin') {
                header('Location: admin_dashboard.php');
            } else {
                header('Location: index.php');
            }
            exit;
        } else {
            $error_message = 'Invalid User ID or Password.';
        }
    } catch (PDOException $e) {
        $error_message = 'Database error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TradeUp</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <div class="login-container">
            <h1>Log In to Your Account</h1>
            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?= htmlspecialchars($error_message) ?></p>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="userId">User ID</label>
                    <input type="text" id="userId" name="userId" required placeholder="Enter your user ID">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                </div>
                <button type="submit">Log In</button>
            </form>
            <p>Don't have an account? <a href="signup.php">Sign up</a></p>
        </div>
    </main>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(120deg, #f0f0f0, #e8e8e8);
        }
        .login-container {
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
