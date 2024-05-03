<?php
session_start();

// Check if the user is logged in and the delete request is sent
if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in'] || !isset($_POST['delete'])) {
    header("Location: login.php");
    exit;
}

// Include database connection details
require_once 'login.php';

// Get the item ID and the user ID from the session
$itemId = $_POST['itemId'] ?? null;
$userId = $_SESSION['user_id'] ?? null;

// Database connection using PDO
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=$chrs", $user, $pass, $opts);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the SQL query to delete the item that belongs to the logged-in user
    $stmt = $conn->prepare("DELETE FROM Item WHERE itemID = ? AND userID = ?");
    $stmt->execute([$itemId, $userId]);

    // Redirect back to the view items page
    header("Location: view_item.php");
    exit;
} catch (PDOException $e) {
    // Handle the error properly - this should ideally log to an error log and not display to the user
    exit('Error: ' . $e->getMessage());
}
?>
