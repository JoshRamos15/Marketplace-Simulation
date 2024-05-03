<?php
session_start();

// Include database connection details
require_once 'login.php';

if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
    echo json_encode(['success' => false, 'error' => 'Not authenticated']);
    exit;
}

// Retrieve POST data
$title = $_POST['title'] ?? null;
$description = $_POST['description'] ?? null;
$price = $_POST['price'] ?? null; // Capture the original price input
$category = $_POST['category'] ?? null;
$itemCondition = $_POST['itemCondition'] ?? null;
$imagePath = $_POST['imagePath'] ?? null;
$userId = $_SESSION['user_id'] ?? null;

// Check if all required fields are provided
if (!$title || !$description || !$price || !$category || !$itemCondition || !$imagePath) {
    echo json_encode(['success' => false, 'error' => 'Missing required item details.']);
    exit;
}

// Sanitize and validate the 'price' input
$price = str_replace(['$', ','], '', $price); // Remove dollar signs and commas
$price = filter_var($price, FILTER_VALIDATE_FLOAT); // Validate the input as a float
if ($price === false) {
    echo json_encode(['success' => false, 'error' => 'Invalid price format.']);
    exit;
}

// Database connection using PDO
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=$chrs", $user, $pass, $opts);

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO Item (userID, dateListed, title, description, price, category, itemCondition, imagePath) VALUES (?, NOW(), ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$userId, $title, $description, $price, $category, $itemCondition, $imagePath]);

    // If insertion was successful
    echo json_encode(["success" => true, "message" => "Item added successfully!"]);
} catch (PDOException $e) {
    // Handle any errors
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}

// Close the database connection
$conn = null;
?>
