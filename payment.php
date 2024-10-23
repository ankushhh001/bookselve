<?php
session_start(); // Ensure session is started

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $conn = new mysqli("localhost", "root", "", "book");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];
    $book_id = $_POST['book_id']; // Get book ID from the form
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $status = 'pending';

    // Fetch book details from 'buy' table using book_id
    $book_sql = "SELECT title, price, class FROM buy WHERE id = ?";
    $book_stmt = $conn->prepare($book_sql);
    $book_stmt->bind_param("i", $book_id);
    $book_stmt->execute();
    $book_result = $book_stmt->get_result();
    
    if ($book_result->num_rows > 0) {
        // Book details found
        $book = $book_result->fetch_assoc();
        $book_title = $book['title'];
        $book_price = $book['price'];
        $book_class = $book['class'];
    } else {
        // If no book found, handle the error
        die("Book not found.");
    }

    // Insert order into 'orders' table
    $stmt = $conn->prepare("INSERT INTO orders (username, name, mobile, address, payment_method, latitude, longitude, status, book_id, book_title, book_price, book_class) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssissi", $_SESSION['username'], $name, $mobile, $address, $payment_method, $latitude, $longitude, $status, $book_id, $book_title, $book_price, $book_class);

    if ($stmt->execute()) {
        // If insertion was successful
        echo "<h2>Purchase successful! Redirecting to home page in 5 seconds...</h2>";

        // Redirect after 5 seconds
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 5000);
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .container {
            width: 90%;
            max-width: 600px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            background-image: url('image4.png'); /* Add the image */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.9; /* 90% transparency */
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input, select, button {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #5cb85c;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Order Details</h1>

    <form action="payment.php" method="POST">
        <!-- Auto-filled and editable fields -->
        Name: <input type="text" name="name" value="<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?>" required><br>
        Mobile: <input type="text" name="mobile" value="<?php echo isset($_SESSION['mobile']) ? $_SESSION['mobile'] : ''; ?>" required><br>
        Address: <input type="text" name="address" required><br>
        
        <!-- Payment method selection -->
        Payment Method: 
        <select name="payment_method" required>
            <option value="COD">Cash on Delivery</option>
            <option value="Debit/Credit Card">Debit/Credit Card</option>
            <option value="Netbanking">Netbanking</option>
            <option value="UPI">UPI</option>
        </select><br>

        <!-- Book ID should be passed as hidden -->
        <input type="hidden" name="book_id" value="<?php echo isset($_GET['book_id']) ? $_GET['book_id'] : ''; ?>"><!-- Safely handle book_id -->
        
        <!-- Location (auto-filled using JavaScript) -->
        <input type="hidden" id="latitude" name="latitude">
        <input type="hidden" id="longitude" name="longitude">
        
        <button type="submit">Place Order</button>
    </form>
</div>

<!-- Google Maps API for capturing the current location -->
<script>
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        alert("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    document.getElementById('latitude').value = position.coords.latitude;
    document.getElementById('longitude').value = position.coords.longitude;
}

// Fetch the location as soon as the page loads
window.onload = getLocation;
</script>

</body>
</html>
