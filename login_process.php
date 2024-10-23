<?php
// Start session
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usernameOrMobile = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Check if user exists by username or mobile number
    $stmt = $conn->prepare("SELECT * FROM registration WHERE username = ? OR mobile = ?");
    $stmt->bind_param("ss", $usernameOrMobile, $usernameOrMobile);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Compare the plain text password directly
        if ($password === $user['password']) {
            // Password is correct, set session variables
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['mobile'] = $user['mobile'];

            // Redirect to homepage or profile
            header("Location: index.php?success=Login successful");
            exit();
        } else {
            // Invalid password
            header("Location: login.php?error=Incorrect password");
            exit();
        }
    } else {
        // User not found
        header("Location: login.php?error=User not found");
        exit();
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>