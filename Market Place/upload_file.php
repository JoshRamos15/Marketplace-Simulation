<?php
session_start();

// Database connection code here...

if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

// Assuming 'image' is the name attribute in your file input form
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    // Define the path where the file will be saved
    $uploadPath = "C:/Program Files/Ampps/www/uploads/";
    $filename = uniqid() . '-' . basename($_FILES['image']['name']);
    $fullPath = $uploadPath . $filename;

    // Move the file from the temporary directory to your desired path
    if (move_uploaded_file($_FILES['image']['tmp_name'], $fullPath)) {
        // Return the web accessible path here
        $webPath = '/uploads/' . $filename;
        echo json_encode(['success' => true, 'filePath' => $webPath]);
    } else {
        echo json_encode(['error' => 'Failed to move uploaded file.']);
    }
} else {
    echo json_encode(['error' => 'No file sent or server error.']);
}
?>
