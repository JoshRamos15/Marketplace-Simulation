<?php
session_start(); // Start the session at the beginning of the script

// Check if the user is logged in, if not redirect to the login page
if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
    header("Location: login.php");
    exit;
}

// Handle the AJAX form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'login.php'; // Include the database connection details

    // Assuming your Item form will have these fields
    $title = $_POST['title']; // The title of the item
    $description = $_POST['description']; // The description of the item
    $price = $_POST['price']; // The price of the item
    $category = $_POST['category']; // The category of the item
    $itemCondition = $_POST['itemCondition']; // The condition of the item
    $imagePath = $_POST['imagePath']; // The image path for the item
    $userId = $_SESSION['user_id']; // Get the logged-in user's ID from the session

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=$chrs", $user, $pass, $opts);
        $stmt = $conn->prepare("INSERT INTO Item (userID, dateListed, title, description, price, category, itemCondition, imagePath) VALUES (?, NOW(), ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$userId, $title, $description, $price, $category, $itemCondition, $imagePath]);
        echo json_encode(["success" => true, "message" => "Item added successfully!"]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }

    $conn = null;
    exit; // Terminate script execution if it's an AJAX request
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KeanTalk</title>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Add styles for the drop zone */
        .drop-zone {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
            cursor: pointer;
        }
    
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #333;
            overflow: auto;
            color: white;
        }

        .navbar a {
            float: left;
            padding: 12px;
            color: white;
            text-decoration: none;
            font-size: 17px;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .active {
            background-color: #666;
        }

        @media screen and (max-width: 500px) {
            .navbar a {
                float: none;
                display: block;
                text-align: left;
            }
        }

        .navbar a.logout {
            float: right;
        }

        .container {
            padding: 15px;
        }

        h2, h3 {
            color: #333;
        }

        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
        }

        .button {
            background-color: #666;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #777;
        }

        .loading {
            display: none;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <a class="active" href="KeanTalk.php">Home</a>
        <a href="Add_New_Item.php">Add New Item</a>
        <a href="logout.php" class="logout">Logout</a>
        <a href="view_item.php" class="ViewItem">View Item</a>
    </div>
    <div class="container">
        <h2>Welcome to the KeanTalk Marketplace</h2>
        <h3>Add New Item</h3>
        <form id="itemForm" method="post" enctype="multipart/form-data">
            <input type="text" name="title" required placeholder="Title"><br>
            <input type="text" name="description" required placeholder="Description"><br>
            <input type="text" name="price" required placeholder="Price"><br>
            <input type="text" name="category" required placeholder="Category"><br>
            <input type="text" name="itemCondition" required placeholder="Condition"><br>
            <!-- Drop zone for image upload -->
            <div class="drop-zone" id="dropZone">
                <input type="file" id="fileInput" name="image" accept="image/*" style="display: none;">
                <label for="fileInput">Drop image here or click to upload</label>
            </div>
            <div id="previewContainer" style="display:none;">
                <img id="uploadedImage" src="" alt="Uploaded Image" style="max-width:100%;height:auto;">
            </div>
            <input type="hidden" name="imagePath" id="imagePath"><br>
            <input type="submit" value="Add Item">
            <div class="loading" id="loadingIndicator">Uploading...</div>
        </form>
    </div>
    <footer class="footer">
        <p>© 2023 KeanTalk Marketplace<br>3.21.2024</p>
        <button class="button" onclick="displayDateTime()">Display Date and Time</button>
        <div id="datetime"></div>
    </footer>
    <script>
$(document).ready(function() {
    // Function to upload files
    function uploadFiles(files) {
        if (files.length > 0) {
            var formData = new FormData();
            formData.append('image', files[0]);
            $('#loadingIndicator').show();
            $.ajax({
                url: 'upload_file.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    try {
                        var jsonResponse = JSON.parse(response);
                        if (jsonResponse.success) {
                            $('#imagePath').val(jsonResponse.filePath);
                            $('#uploadedImage').attr('src', jsonResponse.filePath);
                            $('#previewContainer').show();
                            alert('Your image has been successfully uploaded. You can now submit your item.');
                        } else {
                            alert('Upload error: ' + jsonResponse.error);
                        }
                    } catch (error) {
                        console.error('Error parsing JSON response:', error);
                        console.error('Response:', response);
                        alert('There was an error processing the response.');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX error:', textStatus, 'Error:', errorThrown);
                    alert('Upload failed. Please check the console for more details.');
                },
                complete: function() {
                    $('#loadingIndicator').hide();
                }
            });
        }
    }

    // Drag and Drop Events
    $('#dropZone').on('dragover', function(e) {
        e.preventDefault();
        $(this).addClass('highlight');
    }).on('dragleave', function(e) {
        e.preventDefault();
        $(this).removeClass('highlight');
    }).on('drop', function(e) {
        e.preventDefault();
        $(this).removeClass('highlight');
        var files = e.originalEvent.dataTransfer.files;
        uploadFiles(files);
    });

    // File Input Change Event
    $('#fileInput').change(function() {
        var files = this.files;
        uploadFiles(files);
    });

    // Form Submission Event
    $('#itemForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        if ($('#imagePath').val() !== '') {
            formData.append('imagePath', $('#imagePath').val());
        }
        // AJAX request to add the item
        $.ajax({
            url: 'add_item.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                try {
                    var jsonResponse = JSON.parse(response);
                    if (jsonResponse.success) {
                        alert('Your item has been added successfully!');
                        window.location.href = 'view_item.php'; // Redirect only if successful
                    } else {
                        // Handle the failure
                        alert('Error: ' + jsonResponse.error);
                    }
                } catch (error) {
                    // Handle parsing error here
                    console.error('Error parsing JSON response:', error);
                    console.error('Response:', response);
                    alert('There was an error processing the response.');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle the AJAX request error
                console.error('AJAX error:', textStatus, 'Error:', errorThrown);
                alert('Submission failed. Please check the console for more details.');
            }
        });
    });
});

</script>
</body>
</html>


