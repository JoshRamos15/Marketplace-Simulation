<?php
session_start();

// Display cart contents
if (!empty($_SESSION['cart'])) {
    echo "<h3>Your Cart:</h3>";
    foreach ($_SESSION['cart'] as $itemId => $quantity) {
        echo "Item ID: $itemId, Quantity: $quantity<br>";
    }
} else {
    echo "Your cart is empty.";
}
?>
