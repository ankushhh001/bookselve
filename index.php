<?php
session_start(); // Start the session

// If the user is logged in, retrieve their details from the session
$user_name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
$user_email = isset($_SESSION['email']) ? $_SESSION['email'] : 'No email available';
$user_mobile = isset($_SESSION['mobile']) ? $_SESSION['mobile'] : 'No mobile available';

// Check if the user is logged in for profile access
$isLoggedIn = isset($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>
    <style>
        /* General Styles */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background: url('image.png') no-repeat center center/cover;
            height: 100vh;
            color: #fff;
            overflow-x: hidden;
        }

        /* Top-Right Menu for larger screens */
        .menu {
            position: fixed;
            top: 20px;
            right: 30px;
            z-index: 100;
        }

        .menu a {
            margin: 0 15px;
            text-decoration: none;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
        }

        .menu a:hover {
            color: #3498db;
        }

        /* Main Transparent Box */
        .main-content {
            position: relative;
            width: 90%;
            height: 60%;
            margin: auto;
            top: 20%;
            background: rgba(255, 255, 255, 0.1); /* 90% transparent */
            border-radius: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            padding: 20px;
            backdrop-filter: blur(8px); /* Optional: Gives a nice frosted-glass effect */
        }

        /* Left-Aligned Text */
        .main-content .text-area {
            text-align: left;
            margin-left: 30px;
        }

        .main-content h1 {
            font-size: 42px;
            margin-bottom: 20px;
            color: #fff;
        }

        .main-content h2 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #ddd;
        }

        .main-content p {
            font-size: 16px;
            margin-bottom: 30px;
            color: #ddd;
            width: 60%;
        }

        /* Right Aligned Buttons */
        .button-area {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            margin-right: 60px; /* Adjusted for right alignment */
        }

        .button-area button {
            background: #3498db;
            border: none;
            color: white;
            padding: 15px 30px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 6px;
            margin-bottom: 15px;
            transition: background 0.3s ease;
            width: 150px;
        }

        .button-area button:hover {
            background: #2980b9;
        }

        /* Profile Details Div */
        .profile-details {
            display: none; /* Hidden by default */
            position: absolute;
            top: 60px; /* Position it below the button */
            right: 30px;
            background-color: rgba(255, 255, 255, 0.8);
            color: black;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            z-index: 200;
        }

        /* Close Icon */
        .close-icon {
            cursor: pointer;
            font-weight: bold;
            float: right;
            font-size: 20px;
            color: #333;
        }

        /* Footer */
        footer {
            text-align: center;
            position: absolute;
            bottom: 10px;
            width: 100%;
            color: #fff;
            font-size: 14px;
        }

        /* Mobile Sidebar */
        .menu-toggle {
            display: none;
            position: absolute;
            top: 20px;
            left: 20px;
            cursor: pointer;
        }

        .sidebar {
            position: fixed;
            left: -250px;
            top: 0;
            width: 250px;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            transition: left 0.3s ease;
            z-index: 200;
            padding-top: 60px;
        }

        .sidebar a {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: #fff;
            margin-bottom: 10px;
            text-align: center;
        }

        .sidebar a:hover {
            background-color: #3498db;
        }

        .sidebar.active {
            left: 0;
        }

        /* Mobile Styles */
        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
                z-index: 300;
            }

            .main-content {
                flex-direction: column;
                height: auto;
                top: 10%;
                padding: 20px;
            }

            .main-content h1 {
                font-size: 32px;
            }

            .main-content h2 {
                font-size: 24px;
            }

            .main-content p {
                font-size: 14px;
                width: 100%;
            }

            .button-area {
                align-items: center;
                margin-top: 20px;
            }

            .main-content button {
                padding: 12px 20px;
                font-size: 14px;
            }

            .menu {
                display: none; /* Hide top menu for mobile */
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar for Mobile -->
    <div class="menu-toggle" onclick="toggleSidebar()">
        &#9776;
    </div>

    <div class="sidebar" id="sidebar">
        <a href="#">Home</a>
        <a href="#" onclick="toggleProfileDetails(event)">Profile</a>
        <a href="#">Order</a>
        <a href="#">Contact Us</a>
    </div>

    <!-- Top-Right Menu for desktop -->
    <div class="menu">
        <a href="#">Home</a>
        <a href="#" onclick="toggleProfileDetails(event)">Profile</a>
        <a href="order.php">Order</a>
        <a href="#">Contact Us</a>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <div class="text-area">
            <h1>BOOKSHELF</h1>
            <h2>Making Education Easy</h2>
            <p>On this site, you can buy or sell books fast, safely, and at genuine prices.</p>
            <p>Welcome, <?php echo $user_name; ?>! (<?php echo $user_email; ?>)</p>
        </div>

        <div class="button-area">
            <button onclick="window.location.href=('buy.php')">Buy</button>
            <button  onclick="window.location.href=('sell.php')">Sell</button>
            <button  onclick="window.location.href=('donate.php')">Donate</button>
        </div>
    </div>

    <!-- Profile Details Div -->
    <div class="profile-details" id="profile-details">
        <span class="close-icon" onclick="closeProfileDetails()">✖</span>
        <strong>User Details:</strong><br>
        Name: <?php echo $isLoggedIn ? $user_name : 'N/A'; ?><br>
        Email: <?php echo $isLoggedIn ? $user_email : 'N/A'; ?><br>
        Mobile: <?php echo $isLoggedIn ? $user_mobile : 'N/A'; ?><br>
        <?php if ($isLoggedIn): ?>
            <a href="logout.php">Logout</a>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer>
        © 2024 Book Store. All rights reserved.
    </footer>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }

        function toggleProfileDetails(event) {
            event.preventDefault(); // Prevent default link behavior
            
            // Redirect to login if user is not logged in
            <?php if (!$isLoggedIn): ?>
                window.location.href = "login.php";
            <?php else: ?>
                const profileDetails = document.getElementById('profile-details');
                profileDetails.style.display = (profileDetails.style.display === 'block') ? 'none' : 'block'; // Toggle display
            <?php endif; ?>
        }

        function closeProfileDetails() {
            document.getElementById('profile-details').style.display = 'none'; // Hide profile details
        }
    </script>

</body>
</html>
