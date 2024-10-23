<?php
session_start();  // Always start session at the top

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    header('Location: index.php'); // Redirect to index if logged in
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Book Store</title>
    <style>
        /* General Styles */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            box-sizing: border-box;
            background-color: #f0f0f0;
            background-image: url("image.png");
            height: 100%;
        }

        /* Header */
        header {
            background-color: #295170;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 22px;
        }

        /* Main Content */
        .content {
            margin-top: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 100px); /* Adjust for header and footer */
        }

        /* Login Form */
        .login-box {
            width: 100%;
            max-width: 400px;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 80px;
        }

        .login-box h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .login-box input[type="text"], .login-box input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .login-box button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        .login-box button:hover {
            background-color: #45a049;
        }

        .login-box a {
            color: #4CAF50;
            text-decoration: none;
            display: block;
            margin-top: 15px;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <div>Book Store - Login</div>
    </header>

    <!-- Main Content -->
    <div class="content">
        <div class="login-box">
            <h2>Login</h2>

            <!-- Login Form -->
            <form action="login_process.php" method="POST">
                <input type="text" name="username" placeholder="Enter Username" required>
                <input type="password" name="password" placeholder="Enter Password" required>

                <button type="submit">Login</button>
            </form>

            <!-- Forgot Password and Signup Links -->
            <a href="#">Forgot Password?</a>
            <a href="signup.php">Create an Account</a>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        © 2024 Book Store. All rights reserved.
    </footer>

</body>
</html>
