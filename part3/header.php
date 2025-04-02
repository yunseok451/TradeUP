<?php
// header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TradeUp - Premium Marketplace</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-container">
            <!-- Logo Section -->
            <div class="logo">
                <a href="index.php">TradeUp</a>
            </div>
            <!-- Navigation Section -->
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php">Home</a></li>
                    <li class="dropdown">
                        <a href="#">Categories</a>
                        <ul class="dropdown-menu">
                            <li><a href="sneakers.php">Sneakers</a></li>
                            <li><a href="clothing.php">Clothing</a></li>
                            <li><a href="accessories.php">Accessories</a></li>
                            <li><a href="tech.php">Tech</a></li>
                            <li><a href="lifestyle.php">Lifestyle</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#">Release Info</a>
                        <ul class="dropdown-menu">
                            <li><a href="release_schedule.php">Release Schedule</a></li>
                        </ul>
                    </li>
                    <li><a href="community.php">Community</a></li>
                    <li class="dropdown">
                        <a href="#">Customer Support</a>
                        <ul class="dropdown-menu">
                            <li><a href="faq.php">FAQ</a></li>
                            <li><a href="inquiry.php">1:1 Inquiry</a></li>
                            <li><a href="notice.php">Notices</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- Right Section with Search, Cart, and User Account -->
            <div class="header-right">
                <?php if (isset($_SESSION['nickname'])): ?>
                    <a href="edit_profile.php" class="welcome-message" style="margin-right: 20px;">
                        Welcome, <?= htmlspecialchars($_SESSION['nickname']); ?>!
                    </a>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <a href="admin_dashboard.php" class="btn btn-admin" style="margin-right: 20px;">Admin Panel</a>
                    <?php endif; ?>
                    <a href="cart.php" class="cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                    <a href="logout.php" class="logout-button">Logout</a>
                <?php else: ?>
                    <form class="search-bar" action="search.php" method="GET">
                        <input type="text" name="query" placeholder="Search limited items...">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                    <div class="icons">
                        <a href="cart.php" class="cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                        <a href="login.php" class="user-icon">
                            <i class="fas fa-user"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .logo a {
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
            color: #333;
        }
        .nav-menu {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
            position: relative;
        }
        .nav-menu li {
            margin: 0;
            position: relative;
        }
        .nav-menu a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            padding: 10px 15px;
            display: block;
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            list-style: none;
            padding: 0;
            margin: 0;
            z-index: 10;
        }
        .dropdown-menu li {
            padding: 0;
        }
        .dropdown-menu a {
            text-decoration: none;
            color: #333;
            padding: 10px 15px;
            display: block;
            white-space: nowrap;
        }
        .dropdown:hover .dropdown-menu,
        .dropdown:focus-within .dropdown-menu {
            display: block;
        }
        .header-right {
            display: flex;
            align-items: center;
        }
        .welcome-message {
            font-size: 14px;
            color: #555;
            text-decoration: none;
            font-weight: bold;
        }
        .welcome-message:hover {
            text-decoration: underline;
        }
        .btn-admin {
            padding: 5px 10px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            margin-right: 20px;
        }
        .btn-admin:hover {
            background-color: #0056b3;
        }
        .logout-button {
            padding: 5px 10px;
            background-color: transparent;
            color: #333;
            text-decoration: none;
            border: 1px solid #333;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .logout-button:hover {
            background-color: #333;
            color: #fff;
        }
        .search-bar {
            display: flex;
            border: 1px solid #ddd;
            border-radius: 20px;
            overflow: hidden;
        }
        .search-bar input {
            border: none;
            padding: 5px 10px;
            outline: none;
        }
        .search-bar button {
            background: none;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .icons a {
            margin-left: 20px;
            text-decoration: none;
            color: #333;
            font-size: 18px;
        }
    </style>
</body>
</html>
