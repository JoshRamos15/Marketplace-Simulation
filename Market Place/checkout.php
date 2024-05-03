<?php
session_start();
require_once 'login.php';

// Check out and remove items from database
if (isset($_POST['checkout']) && isset($_SESSION['cart'])) {
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=$chrs", $user, $pass, $opts);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        foreach ($_SESSION['cart'] as $itemId => $quantity) {
            // Remove item from the database
            $stmt = $conn->prepare("DELETE FROM Item WHERE itemID = ?");
            $stmt->execute([$itemId]);
        }

        // Clear the cart
        $_SESSION['cart'] = array();

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
    header('Location: view_item.php');
    exit;
}
?>
