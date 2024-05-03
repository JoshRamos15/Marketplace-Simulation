<?php
session_start();

// Check if the user is logged in, if not, then redirect to the login page
if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
    header("Location: login.php");
    exit;
}

// Include database connection details
require_once 'login.php';

$message = ''; // Message to display after an action

try {
    // Create a new PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=$chrs", $user, $pass, $opts);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handle buy action
    if (isset($_POST['buy'])) {
        $itemId = $_POST['itemId'];
        $deleteStmt = $conn->prepare("DELETE FROM Item WHERE itemID = ?");
        $deleteStmt->execute([$itemId]);
        $message = "Thank you for buying!";
    }

    // Prepare the SQL query to fetch all items from all users
    $stmt = $conn->prepare("SELECT i.*, u.username FROM Item i LEFT JOIN users u ON i.userID = u.id");
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KeanTalk Marketplace - View Items</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
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
        .navbar a.logout {
            float: right;
        }
        .container {
            padding: 15px;
        }
        h2 {
            color: #333;
        }
        .items {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            gap: 20px;
        }
        .item-card {
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 300px;
            background-color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .item-card img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }
        .item-info {
            padding: 15px;
            flex-grow: 1;
        }
        .item-info h3, .item-info p {
            margin: 10px 0;
        }
        .btn-delete, .btn-buy {
            background-color: #ff4444;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 0;
            cursor: pointer;
            width: 100%;
        }
        .btn-buy {
            background-color: #4CAF50; /* Green */
        }
        .btn-delete:hover, .btn-buy:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a class="active" href="KeanTalk.php">Home</a>
        <a href="Add_New_Item.php">Add New Item</a>
        <a href="view_item.php">View Item</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>
    <div class="container">
        <h2>Welcome to the KeanTalk Marketplace</h2>
        <?php if (!empty($message)) echo "<p>$message</p>"; ?>
        <div class="items">
            <?php foreach ($items as $item): ?>
                <?php if (!empty($item['title']) && !empty($item['description']) && !empty($item['price'])): ?>
                    <div class="item-card">
                        <?php if (!empty($item['imagePath'])): ?>
                            <img src="<?php echo htmlspecialchars($item['imagePath']); ?>" alt="Item Image">
                        <?php endif; ?>
                        <div class="item-info">
                            <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                            <p><strong>Description:</strong> <?php echo htmlspecialchars($item['description']); ?></p>
                            <p><strong>Price:</strong> $<?php echo htmlspecialchars($item['price']); ?></p>
                            <p><strong>Category:</strong> <?php echo htmlspecialchars($item['category']); ?></p>
                            <p><strong>Condition:</strong> <?php echo htmlspecialchars($item['itemCondition'] ?? 'Not specified'); ?></p>
                            <p><strong>Posted by:</strong> <?php echo htmlspecialchars($item['username']); ?></p>
                        </div>
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $item['userID']): ?>
                            <form method="POST" action="delete_item.php" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                <input type="hidden" name="itemId" value="<?php echo $item['itemID']; ?>">
                                <button type="submit" class="btn-delete" name="delete">Delete</button>
                            </form>
                        <?php else: ?>
                            <form method="POST" action="view_item.php">
                                <input type="hidden" name="itemId" value="<?php echo $item['itemID']; ?>">
                                <input type="hidden" name="buy" value="1">
                                <button type="submit" class="btn-buy" name="buy">Buy</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
