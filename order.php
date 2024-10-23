<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <style>
        /* General Styles */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            box-sizing: border-box;
            background-color: #f0f0f0;
            background: url('image4.png') no-repeat center center/cover;
        }
        header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            font-size: 22px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            padding: 15px 0;
        }
        h2, h3 {
            color: #333;
            margin-bottom: 50px;
        }
        .order-section {
            margin-bottom: 30px;
            margin-top: 60px; /* Ensure content is visible below the fixed header */
        }
        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .order-table th, .order-table td {
            padding: 15px;
            border: 1px solid #ccc;
            text-align: left;
        }
        .order-item {
            background-color: #fff;
        }
        .green {
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .yellow {
            background-color: #fff3cd;
            border-color: #ffeeba;
        }
        .red {
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        select, button {
            padding: 8px 12px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        select {
            width: 200px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .form-section {
            margin-bottom: 20px;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            header {
                font-size: 18px; 
            }
            .go-back-btn {
                font-size: 16px; /* Smaller size for mobile */
                padding: 5px; /* Adjust padding */
            }
            h2, h3 {
                font-size: 18px; 
            }
            .order-table th, .order-table td {
                padding: 10px; 
                font-size: 12px; 
            }
        }
    </style>
</head>
<body>
<header>
    <button class="go-back-btn" onclick="window.location.href='index.php'">
        &#11013; Back
    </button>
    <div>ORDERS</div>
</header>

<h2>Your Order History</h2>

<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'book';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the user is logged in
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

$user = $_SESSION['username']; // Get logged-in username

// Fetch user details (name or mobile) from the registration table
$user_details_query = "SELECT name, mobile FROM registration WHERE username = '$user'";
$user_details_result = mysqli_query($conn, $user_details_query);

if ($user_details_row = mysqli_fetch_assoc($user_details_result)) {
    $name = $user_details_row['name'];
    $mobile = $user_details_row['mobile'];
}

// Function to style rows based on status
function getStatusClass($status) {
    switch (strtolower($status)) {
        case 'success':
            return 'green';
        case 'pending':
            return 'yellow';
        case 'cancel':
            return 'red';
        default:
            return '';
    }
}

// Check if the user has selected an order type
$order_type = isset($_POST['order_type']) ? $_POST['order_type'] : 'all';

// Form for selecting the type of orders to view
echo "<form method='POST' action=''>
    <label for='order_type'>Select Order Type:</label>
    <select name='order_type' id='order_type'>
        <option value='buy' " . ($order_type == 'buy' ? 'selected' : '') . ">Buy Orders</option>
        <option value='sell' " . ($order_type == 'sell' ? 'selected' : '') . ">Sell Orders</option>
        <option value='donate' " . ($order_type == 'donate' ? 'selected' : '') . ">Donation Orders</option>
        <option value='all' " . ($order_type == 'all' ? 'selected' : '') . ">All Orders</option>
    </select>
    <button type='submit'>View</button>
</form>";

// Display selected orders based on the form submission
if ($order_type == 'buy' || $order_type == 'all') {
    // Buy orders
    echo "<div class='order-section'><h3>Buy Orders</h3>";
    $query_buy = "SELECT * FROM orders WHERE username = '$user'";
    $result_buy = mysqli_query($conn, $query_buy);

    if (mysqli_num_rows($result_buy) > 0) {
        echo "<table class='order-table'>
                <tr>
                    <th>Title</th>
                    <th>Class</th>
                    <th>Price</th>
                    <th>Status</th>
                </tr>";
        while ($row = mysqli_fetch_assoc($result_buy)) {
            $status_class = getStatusClass($row['status']);
            echo "<tr class='$status_class order-item'>
                    <td>{$row['book_title']}</td>
                    <td>{$row['book_class']}</td>
                    <td>{$row['book_price']}</td>
                    <td>{$row['status']}</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No buy orders found.";
    }
    echo "</div>";
}

if ($order_type == 'sell' || $order_type == 'all') {
    // Sell orders
    echo "<div class='order-section'><h3>Sell Orders</h3>";
    $query_sell = "SELECT * FROM sell WHERE username = '$user'";
    $result_sell = mysqli_query($conn, $query_sell);

    if (mysqli_num_rows($result_sell) > 0) {
        echo "<table class='order-table'>
                <tr>
                    <th>Book Title</th>
                    <th>Class</th>
                    <th>Price</th>
                    <th>Status</th>
                </tr>";
        while ($row = mysqli_fetch_assoc($result_sell)) {
            $status_class = getStatusClass($row['status']);
            echo "<tr class='$status_class order-item'>
                    <td>{$row['book_title']}</td>
                    <td>{$row['class']}</td>
                    <td>{$row['price']}</td>
                    <td>{$row['status']}</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No sell orders found.";
    }
    echo "</div>";
}

if ($order_type == 'donate' || $order_type == 'all') {
    // Donation orders
    echo "<div class='order-section'><h3>Donation Orders</h3>";
    $query_donate = "SELECT * FROM donate WHERE username = '$user'";
    $result_donate = mysqli_query($conn, $query_donate);

    if (mysqli_num_rows($result_donate) > 0) {
        echo "<table class='order-table'>
                <tr>
                    <th>Book Title</th>
                    <th>Class</th>
                    <th>Status</th>
                </tr>";
        while ($row = mysqli_fetch_assoc($result_donate)) {
            $status_class = getStatusClass($row['status']);
            echo "<tr class='$status_class order-item'>
                    <td>{$row['title']}</td>
                    <td>{$row['class']}</td>
                    <td>{$row['status']}</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No donation orders found.";
    }
    echo "</div>";
}

mysqli_close($conn);
?>
</body>
</html>
