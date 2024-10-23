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
            font-family: Arial, sans-serif;
            box-sizing: border-box;
            background-color: #f0f0f0;
            background-size: cover;
            background-position: center;
            height: 100%;
        }

        /* Header */
        header {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 22px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        /* Toggle Button for Sidebar */
        .toggle-btn {
            background-color: #4CAF50;
            padding: 10px;
            font-size: 24px;
            color: white;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1001;
            cursor: pointer;
        }

        /* Sidebar */
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 60px;
            left: -250px;
            background-color: #333;
            padding-top: 20px;
            z-index: 999;
            transition: left 0.3s ease;
        }

        .sidebar a {
            padding: 15px 8px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            text-align: center;
            border-bottom: 1px solid #555;
        }

        .sidebar a:hover {
            background-color: #4CAF50;
        }

        /* Main Content */
        .content {
            margin-top: 140px;
            text-align: center;
        }

        /* Boxed Buttons */
        .box {
            width: 100%;
            max-width: 400px;
            margin: 20px auto;
        }

        .box button {
            width: 100%;
            padding: 20px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin-bottom: 15px;
            font-size: 18px;
            cursor: pointer;
        }

        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1001;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
        }

        .modal-content {
            background-color: white;
            margin: 8% auto;
            padding: 20px;
            width: 80%;
            max-width: 400px;
            text-align: center;
            border-radius: 10px;
        }

        .modal-close {
            float: right;
            cursor: pointer;
            color: #4CAF50;
            font-size: 18px;
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

        /* Mobile and Tablet View */
        @media screen and (max-width: 768px) {
            .content {
                margin-left: 0;
                padding: 20px;
            }
        }

        /* Open sidebar on desktop view */
        @media screen and (min-width: 769px) {
            .sidebar {
                left: 0;
            }

            .toggle-btn {
                display: none;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <span class="toggle-btn" id="toggle-btn">&#9776;</span>
        <div>Book Store</div>
    </header>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a href="index.php">Home</a>
        <a href="login.php" id="openProfileModalBtn">Profile</a>
        <a href="#order">Order</a>
        <a href="#help">Help & Support</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="box">
            <button>Buy Books</button>
        </div>
        <div class="box">
            <button>Sell Books</button>
        </div>
        <div class="box">
            <button>Donate Books</button>
        </div>
    </div>

    <!-- Profile Modal -->
    <div class="modal" id="profileModal">
        <div class="modal-content">
            <span class="modal-close" id="closeProfileModalBtn">&times;</span>
            <h2>Profile</h2>

            <?php if (isset($_SESSION['username'])): ?>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                <p><strong>Mobile:</strong> <?php echo htmlspecialchars($_SESSION['mobile']); ?></p>

                <a href="logout.php" style="color: #4CAF50;">Logout</a>
            <?php else: ?>
                <p>Please <a href="#" id="openLoginModal" style="color: #4CAF50;">log in</a> to view your profile.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        © 2024 Book Store. All rights reserved.
    </footer>

    <!-- JavaScript to Manage Sidebar and Modal -->
    <script>
        // Sidebar Toggle
        var toggleBtn = document.getElementById('toggle-btn');
        var sidebar = document.getElementById('sidebar');
        var isSidebarOpen = false;

        toggleBtn.onclick = function() {
            if (!isSidebarOpen) {
                sidebar.style.left = '0';
            } else {
                sidebar.style.left = '-250px';
            }
            isSidebarOpen = !isSidebarOpen;
        };

        // Profile Modal Toggle
        var openProfileModalBtn = document.getElementById('openProfileModalBtn');
        var profileModal = document.getElementById('profileModal');
        var closeProfileModalBtn = document.getElementById('closeProfileModalBtn');

        openProfileModalBtn.onclick = function() {
            profileModal.style.display = 'block';
        };

        closeProfileModalBtn.onclick = function() {
            profileModal.style.display = 'none';
        };

        window.onclick = function(event) {
            if (event.target == profileModal) {
                profileModal.style.display = 'none';
            }
        };
    </script>

</body>
</html>
