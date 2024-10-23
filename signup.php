<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            background-image: url("image.png");
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
         /* Header */
         header {
            background-color: black;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 22px;
        }

        .signup-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin-top:200px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .error, .success {
            text-align: center;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            font-weight: bold;
            display: none;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>

<div class="signup-container">
    <h2>Sign Up</h2>
    <?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Function to generate random user ID
function generateRandomUserId($length = 10) {
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}

// Form submission handling
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input
    $name = $conn->real_escape_string($_POST['name']);
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $mobile = $conn->real_escape_string($_POST['mobile']);
    $password = $conn->real_escape_string($_POST['password']);

    // Generate a random user ID
    $userId = generateRandomUserId();

    // Check if username, email, or mobile already exists
    $checkQuery = "SELECT * FROM registration WHERE username='$username' OR email='$email' OR mobile='$mobile'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // User already exists
        echo "Username, email, or mobile number already exists.";
    } else {
        // Insert new user into the database
        $sql = "INSERT INTO registration (user_id, name, username, email, mobile, password)
                VALUES ('$userId', '$name', '$username', '$email', '$mobile', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "New user registered successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close the connection
    $conn->close();
}
?>


<!-- Signup Form -->
    <form action="connect.php" method="POST" id="signupForm">
        <input type="hidden" name="action" value="register">
        
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter Full Name" required>

        <label for="mobile">Mobile:</label>
        <input type="text" id="mobile" name="mobile" placeholder="Enter Mobile Number" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter Email Address" required>
        
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Enter Username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter Password" required>
        
        <button type="submit">Sign Up</button>
    </form>

    <!-- Success/Error Dialog Boxes -->
    <div class="success" id="successMessage">Sign up successful! Redirecting...</div>
    <div class="error" id="errorMessage">signup failed</div>

    <p style="text-align:center;">Already have an account? <a href="login.php">Login</a></p>
</div>

<script>
    const urlParams = new URLSearchParams(window.location.search);

    // Show success message if signup is successful
    if (urlParams.has('success')) {
        document.getElementById('successMessage').style.display = 'block';
        setTimeout(function() {
            window.location.href = 'index.php';  // Redirect to profile page after success
        }, 2000);
    }

    // Show error message if signup failed
    if (urlParams.has('error')) {
        const errorMsg = urlParams.get('error');
        document.getElementById('errorMessage').innerText = errorMsg;
        document.getElementById('errorMessage').style.display = 'block';
    }
</script>

</body>
</html>
