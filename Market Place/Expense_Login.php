<?php
session_start();
$loginError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'login.php'; // Ensure this file contains the correct database credentials

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Update the pattern to include spaces and adjust the length validation
    $usernamePattern = '/^[a-zA-Z\s]{5,30}$/'; // Allowing spaces in usernames
    $passwordPattern = '/^[a-zA-Z0-9]{6,}$/';

    // Validate username
    if (!preg_match($usernamePattern, $username)) {
        $loginError = 'Invalid username format.';
    }
    // Validate password
    elseif (!preg_match($passwordPattern, $password)) {
        $loginError = 'Invalid password format.';
    }
    else {
        try {
            $conn = new PDO($attr, $user, $pass, $opts);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch();

            // Compare the plaintext passwords
            if ($user && $user['password'] === $password) {
                $_SESSION['user_logged_in'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $user['id']; // Storing the user's ID in the session

                header("Location: KeanTalk.php");
                exit;
            } else {
                $loginError = 'Invalid username or password.';
            }
        } catch(PDOException $e) {
            $loginError = "Error: " . $e->getMessage();
        }
        $conn = null;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login - KeanTalk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }

        h2 {
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            display: inline-block;
            margin-top: 20px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #aaa;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #333;
            color: white;
            padding: 10px 15px;
            margin: 10px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #1a1a1a;
        }

        .error-message {
            color: #ff0000;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2>Login to KeanTalk</h2>

    <?php if ($loginError): ?>
        <p class="error-message"><?php echo $loginError; ?></p>
    <?php endif; ?>

    <form method="post">
        Username: <br><input type="text" name="username" required><br>
        Password: <br><input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
