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

// Check if user is logged in and get username and mobile number
if (!isset($_SESSION['username'])) {
    echo "Please log in to sell a book.";
    exit;
}

$current_user = $_SESSION['username'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_title = $_POST['book_title'];
    $author = $_POST['author'];
    $description = $_POST['description'];
    $address = $_POST['address'];
    $price_message = '100-200 waiting for admin approval';
    $class = $_POST['class'];
    $board = $_POST['board'];
    $state_board = isset($_POST['state_board']) ? $_POST['state_board'] : null;

    // Create a directory to store uploaded images if it doesn't exist
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Prepare an array to hold the file paths of uploaded images
    $image_paths = [];

    // Loop through uploaded files
    foreach ($_FILES['images']['name'] as $key => $name) {
        // Check for upload errors
        if ($_FILES['images']['error'][$key] == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['images']['tmp_name'][$key];
            $new_name = uniqid() . '_' . basename($name);
            $upload_file = $upload_dir . $new_name;

            // Move the uploaded file to the desired location
            if (move_uploaded_file($tmp_name, $upload_file)) {
                $image_paths[] = $upload_file; // Store the image path
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Error uploading file: " . $_FILES['images']['error'][$key];
        }
    }

    // Insert sell request into the orders table
    $image_paths_string = implode(',', $image_paths); // Convert image paths to a string
    $query = "INSERT INTO sell (username, book_title, author, description, class, board, state_board, images, address, type, status, price)
              VALUES ('$current_user', '$book_title', '$author', '$description', '$class', '$board', '$state_board', '$image_paths_string','$address', 'sell', 'pending','checking by admin')";

    if (mysqli_query($conn, $query)) {
        echo "<h2>Request sent successfully! </h2>
        redirect to home page within 5 sec";
    
        // Use JavaScript to redirect after 5 seconds
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 5000);
              </script>";
        exit; // Stop further script execution
    }
    } else {
        echo "Error: " . mysqli_error($conn);
    }


$conn->close();
?>