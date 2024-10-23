<?php
// Start session
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'book'); // Replace with your database credentials

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // If the form is for login
    if (isset($_POST['action']) && $_POST['action'] == 'login') {
        $usernameOrMobile = $_POST['username'];
        $password = $_POST['password'];

        // Query to check if the user exists by either username or mobile
        $stmt = $conn->prepare("SELECT * FROM registration WHERE username = ? OR mobile = ?");
        $stmt->bind_param("ss", $usernameOrMobile, $usernameOrMobile); // Binding for both username and mobile fields
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            // Debug: Output the stored hash and entered password
            echo "Stored hash: " . $user['password'] . "<br>";
            echo "Entered password: " . $password . "<br>";

            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Correct password, set session and redirect
                $_SESSION['username'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['mobile'] = $user['mobile'];
                header("Location: profile.php?success=" . urlencode("Login successful!"));
                exit();
            } else {
                // Debug: Show a message if the password verification fails
                echo "Password verification failed. Hash and entered password do not match.<br>";
                header("Location: login.php?error=" . urlencode("Invalid password."));
                exit();
            }
        } else {
            // Username or mobile not found
            header("Location: login.php?error=" . urlencode("Username or mobile not found."));
            exit();
        }
    }

    // If the form is for registration (sign-up)
    if (isset($_POST['action']) && $_POST['action'] == 'register') {
        $name = $_POST['name'];
        $mobile = $_POST['mobile'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password']; // Ensure password is hashed

        // Check if username or mobile already exists
        $checkUserStmt = $conn->prepare("SELECT * FROM registration WHERE username = ? OR mobile = ?");
        $checkUserStmt->bind_param("ss", $username, $mobile);
        $checkUserStmt->execute();
        $result = $checkUserStmt->get_result();

        if ($result->num_rows > 0) {
            // Username or Mobile already exists, show error
            $row = $result->fetch_assoc();
            if ($row['username'] == $username) {
                $error = "Username already taken.";
            } elseif ($row['mobile'] == $mobile) {
                $error = "Mobile number already exists.";
            }

            // Redirect back with error message
            header("Location: signup.php?error=" . urlencode($error));
            exit();
        } else {
            // Insert the new user data into the database
            $stmt = $conn->prepare("INSERT INTO registration (name, mobile, email, username, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $mobile, $email, $username, $password);
            $stmt->execute();

            // Redirect with success message
            header("Location: login.php?success=" . urlencode("Account created successfully. Please log in."));
            exit();
        }
    }
}

// Close connection
$conn->close();
?>
