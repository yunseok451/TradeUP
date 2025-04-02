<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $table = $_POST['table'];

    // Add the product to the cart
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $_SESSION['cart'][] = ['table' => $table, 'id' => $productId];

    header('Location: cart.php');
    exit();
}
?>
