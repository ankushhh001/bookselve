<?php
// Start session to check login status
session_start();

// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'book');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch class from the form submission
$class = isset($_POST['class']) ? $_POST['class'] : 'All';

// Fetch books based on the selected class
if ($class == 'All') {
    $query = "SELECT * FROM buy";
} else {
    $query = "SELECT * FROM buy WHERE class = '$class'";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styling */
        body { 
            background-color: #f8f9fa; 
            font-family: Arial, sans-serif;
            background: url('image2.jpg') no-repeat center center/cover;
        }
        .header { 
            background-color: #343a40; 
            padding: 10px; 
            text-align: center; 
            color: white; 
        }
        .back-btn { 
            color: white; 
            text-decoration: none; 
            font-size: 18px; 
        }
        .container { 
            margin-top: 20px; 
        }
        .book-card { 
            background-color: rgba(255, 255, 255, 0.9); /* 70% transparency */
            border-radius: 8px; 
            padding: 15px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.9); 
            margin-bottom: 20px; 
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.8s ease-out, opacity 1s ease-out;
            opacity: 0;
        }
        .book-card.show {
            max-height: 1000px; /* enough to show content */
            opacity: 1;
        }
        .scroll-unfurl {
            animation: unfurl 0.5s ease-in-out forwards;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Available Books</h2>
        <form method="POST" action="buy.php">
            <div class="row mb-3">
                <div class="col-md-3">
                    <select name="class" class="form-control" aria-label="Select Class">
                        <option value="All" <?php if ($class == 'All') echo 'selected'; ?>>All</option>
                        <option value="9" <?php if ($class == '9') echo 'selected'; ?>>Class 9</option>
                        <option value="10" <?php if ($class == '10') echo 'selected'; ?>>Class 10</option>
                        <option value="11" <?php if ($class == '11') echo 'selected'; ?>>Class 11</option>
                        <option value="12" <?php if ($class == '12') echo 'selected'; ?>>Class 12</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">View Books</button>
                </div>
            </div>
        </form>

        <div class="row">
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="container">
    <div class="row">
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <div class="col-md-4">
            <div class="card">
                <!-- Image -->
                <img src="<?php echo $row['image_url']; ?>" alt="Book Image" class="card-img-top" style="width: 100%; height: auto;">
                
                <!-- Book Details -->
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['title']; ?></h5>
                    <p class="card-text">Author: <?php echo $row['author']; ?></p>
                    <p class="card-text">Price: <?php echo $row['price']; ?></p>

                    <!-- Buttons -->
                    <button class="btn btn-primary" onclick="handleBuyNow('<?php echo $row['id']; ?>')">Buy Now</button>
                    <button class="btn btn-secondary" onclick="handleAddToCart('<?php echo $row['id']; ?>')">Add to Cart</button>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

                <?php endwhile; ?>
            <?php else: ?>
                <p>No books available for the selected class.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function checkLogin() {
            <?php if (!isset($_SESSION['username'])): ?>
                window.location.href = 'login.php'; // Redirect to login if not logged in
                return false;
            <?php else: ?>
                return true;
            <?php endif; ?>
        }

        function handleBuyNow(bookId) {
            if (checkLogin()) {
                window.location.href = `payment.php?book_id=${bookId}`; // Redirect to details.php with book ID
            }
        }

        function handleAddToCart(bookId) {
            if (checkLogin()) {
                // Logic to add the book to the cart
                alert('Book added to cart!');
                // Add actual cart functionality as needed
            }
        }

        // Scroll open animation is triggered automatically on load for book cards.
        document.querySelectorAll('.scroll-unfurl').forEach(function(card) {
            setTimeout(function() {
                card.querySelector('.book-card').classList.add('show');
            }, 500); // Delay to trigger animation after load
        });
    </script>

</body>
</html>


