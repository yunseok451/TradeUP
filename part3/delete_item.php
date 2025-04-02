<?php
// delete_item.php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['table'])) {
    $productId = intval($_POST['product_id']);
    $table = $_POST['table'];

    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $productId && $item['table'] === $table) {
                unset($_SESSION['cart'][$key]);
                break;
            }
        }
        // Reindex the cart array
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }

    header('Location: checkout.php');
    exit();
} else {
    header('Location: checkout.php');
    exit();
}
?>
