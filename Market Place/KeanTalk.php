<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
    <script>
        function displayDateTime() {
            var currentDateTime = new Date();
            var date = currentDateTime.toDateString();
            var time = currentDateTime.toLocaleTimeString();
            document.getElementById("datetime").innerHTML = "Current Date and Time: " + date + " " + time;
        }
    </script>
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

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            background-color: #ddd;
            margin: 5px 0;
            padding: 5px;
            border-radius: 5px;
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
    </style>
</head>

<body>
    <div class="navbar">
        <a class="active" href="ExpenseTracker.php">Home</a>
        <a href="Add_New_item.php">Add New Item</a>
        <a href="view_item.php">View Item</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <div class="container">
    <h2>Welcome to the KeanTalk MarketPlace</h2>
    <p>Welcome to our vibrant Marketplace platform. This intuitive interface is designed to connect buyers and sellers, enabling you to list your items for sale and shop for what you need easily.</p>

    <h3>Marketplace Features:</h3>
    <ul>
        <li><strong>Account Management:</strong> Secure user accounts to manage your listings and purchases.</li>
        <li><strong>List Items:</strong> Post items for sale with images, descriptions, and pricing.</li>
        <li><strong>Browse Listings:</strong> Explore a variety of items through a user-friendly browsing experience.</li>
        <li><strong>Remove Listings:</strong> Delete any of your items that have sold or are no longer available.</li>
    </ul>

    <p>Our mission is to provide an easy-to-use platform for our community to buy and sell items. Whether you're decluttering your space, finding treasures, or seeking the perfect item, our marketplace is the right place for you. Get started by signing in and exploring the marketplace!</p>
</div>


    <footer class="footer">
        <p><b>© 2023  KeanTalk</b><br>3.21.2024</p>
        <button class="button" onclick="displayDateTime()">Display Date and Time</button>
        <p id="datetime"></p>
    </footer>
</body>
</html>
