<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'buy_now') {
    $productId = $_POST['product_id'];

    // Simulate order processing
    $_SESSION['order'] = $productId;

    // Redirect to an order confirmation page
    header('Location: order_confirmation.php');
    exit();
}
?>
