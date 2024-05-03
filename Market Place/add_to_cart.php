<?php
session_start();

// Add item to cart
if (isset($_POST['add_to_cart'])) {
    $itemId = $_POST['itemId'];
    $itemQuantity = $_POST['quantity'];

    // Initialize cart if not already set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Add item to cart
    $_SESSION['cart'][$itemId] = $itemQuantity;

    header('Location: view_item.php');
    exit;
}
?>
