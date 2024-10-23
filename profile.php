<?php
// Start session
// Add this to the start of your page
ini_set('session.gc_maxlifetime', 3600);  // 1 hour session
session_set_cookie_params(3600);  // 1 hour for the session cookie


session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to login page
    header("Location: login.php?error=" . urlencode("Please login to view your profile."));
    exit();
}

// Connect to database
$servername = "localhost";
$username = "root";  // Update with your DB username
$password = "";      // Update with your DB password
$dbname = "book";  // Update with your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data based on session username
$sql = "SELECT name, email, mobile FROM registration WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['username']);  // Bind the username from the session
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    // Fetch user data
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
    $mobile = $row['mobile'];
} else {
    echo "No user found!";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        /* Your CSS styles */
    </style>
</head>
<body>
<div class="profile-container">
    <h2>User Profile</h2>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
    <p><strong>Mobile:</strong> <?php echo htmlspecialchars($mobile); ?></p>

    <button onclick="window.location.href='home.php';">Back to Home</button>
    <a href="logout.php">Logout</a>
</div>
</body>
</html>
