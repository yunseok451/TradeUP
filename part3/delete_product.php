<?php
session_start();

// Check if the user is an admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Get table name from URL parameter
$table = isset($_GET['table']) ? $_GET['table'] : 'sneakers';

if (isset($_GET['id'])) {
    try {
        // Connect to the database
        $pdo = new PDO('mysql:host=localhost;dbname=tradeup', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Delete the product from the specified table
        $stmt = $pdo->prepare("DELETE FROM $table WHERE id = ?");
        $stmt->execute([$_GET['id']]);

        header('Location: admin_dashboard.php?table=' . $table);
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    header('Location: admin_dashboard.php?table=' . $table);
    exit();
}
?>
