<?php
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

// Fetch books based on class
$class = $_GET['class'] ?? '';
$searchTerm = $_GET['search'] ?? '';

$sql = "SELECT * FROM buy WHERE 1";

if ($class) {
    $sql .= " AND (class = $class OR $class = 0)";
}
if ($searchTerm) {
    $sql .= " AND (title LIKE '%$searchTerm%' OR author LIKE '%$searchTerm%')";
}

$result = $conn->query($sql);
$books = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}

// Close connection
$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($books);
