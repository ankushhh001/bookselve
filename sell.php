<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Old Books</title>
    <style>
        /* General Styles */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            box-sizing: border-box;
            background-color: #f0f0f0;
            background: url('image2.jpg') no-repeat center center/cover;
        }

        /* Header (Top Navigation Bar) */
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

        /* Go Back Button */
        .go-back-btn {
            position: absolute;
            left: 15px;
            top: 15px;
            font-size: 24px;
            color: white;
            background: none;
            border: none;
            cursor: pointer;
            color:blue;
        }

        .go-back-btn i {
            font-size: 24px;
            color: black;
        }

        /* Main Content */
        .content {
            margin-top: 120px;
            padding: 20px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .content h2 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        /* Input fields and icons */
        .input-container {
            position: relative;
            margin-bottom: 20px;
            width: 80%;
        }

        .input-container i {
            position: absolute;
            left: 10px;
            top: 10px;
            font-size: 18px;
            color: #4CAF50;
        }

        .input-container input, .input-container textarea, .input-container select {
            width: 100%;
            padding: 10px 10px 10px 40px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Submit Button */
        .submit-btn {
            width: 100%;
            padding: 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }

        /* Additional Fields */
        .state-board-container {
            display: none;
        }

        /* File Upload and Gallery/Capture Options */
        .file-container, .gallery-camera-options {
            display: none;
        }

        .gallery-camera-options label {
            display: flex;
            align-items: center;
            margin-right: 20px;
            font-size: 16px;
        }

        .gallery-camera-options input {
            margin-right: 10px;
        }

        .gallery-camera-options {
            margin-bottom: 20px;
        }
        .box { 
            background-color: rgba(255, 255, 255, 0.9);
        }
    </style>

    <!-- FontAwesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

    <!-- Header (Top Navigation Bar) -->
    <header>
        <button class="go-back-btn" onclick="window.location.href='index.php'">
        &#11013
        </button>
        <div>Sell Your Old Books</div>
    </header>

    <!-- Main Content -->
    <div class="content">
        <h2>Sell Your Old Books</h2>
        <form id="sellBookForm" action="sell_books.php" method="POST" enctype="multipart/form-data" class="box">
    <div class="input-container">
        <i class="fas fa-book"></i>
        <input type="text" name="book_title" placeholder="Book Title" required>
    </div>
    <div class="input-container">
        <i class="fas fa-user"></i>
        <input type="text" name="author" placeholder="Author" required>
    </div>
    <div class="input-container">
        <i class="fas fa-clipboard"></i>
        <select name="condition" required>
            <option value="" disabled selected>Condition of the Book</option>
            <option value="New">New</option>
            <option value="Like New">Like New</option>
            <option value="Good">Good</option>
            <option value="Fair">Fair</option>
            <option value="Poor">Poor</option>
        </select>
    </div>
    <div class="input-container">
        <i class="fas fa-graduation-cap"></i>
        <select name="class" required>
            <option value="" disabled selected>Select Class</option>
            <option value="9">Class 9</option>
            <option value="10">Class 10</option>
            <option value="11">Class 11</option>
            <option value="12">Class 12</option>
        </select>
    </div>
    <div class="input-container">
        <i class="fas fa-school"></i>
        <select name="board" id="boardSelect" required>
            <option value="" disabled selected>Select Board</option>
            <option value="board">CBSE</option>
            <option value="board">ICSE</option>
            <option value="State Board">State Board</option>
            <option value="Other">Other</option>
        </select>
    </div>

    <div class="input-container state-board-container" id="stateBoardContainer">
        <i class="fas fa-map-marker-alt"></i>
        <select name="state_board">
            <option value="" disabled selected>Select State Board</option>
            <option value="Maharashtra">Maharashtra State Board</option>
            <option value="Karnataka">Karnataka State Board</option>
            <option value="Tamil Nadu">Tamil Nadu State Board</option>
        </select>
    </div>

    <div class="input-container">
        <i class="fas fa-pencil-alt"></i>
        <textarea name="description" placeholder="Description of the Book" rows="5" required></textarea>
    </div>

    <div class="input-container">
    <i class="fas fa-camera"></i>
    <input type="file" name="images[]" id="BookImage" accept="image/*" multiple required>
    <textarea name="address" placeholder="pickup address" rows="8" required></textarea>
    </div>


    <button type="submit" class="submit-btn">Submit</button>
</form>

    </div>

    <script>
        // Show state board options when State Board is selected
        const boardSelect = document.getElementById("boardSelect");
        const stateBoardContainer = document.getElementById("stateBoardContainer");

        boardSelect.addEventListener("change", function () {
            if (this.value === "State Board") {
                stateBoardContainer.style.display = "block";
            } else {
                stateBoardContainer.style.display = "none";
            }
        });

        // Show gallery or camera options after selecting a file
        const bookImageInput = document.getElementById("bookImage");
        const galleryCameraOptions = document.getElementById("galleryCameraOptions");

        bookImageInput.addEventListener("change", function () {
            if (this.files.length > 0) {
                galleryCameraOptions.style.display = "block";
            }
        });
    </script>

</body>
</html>
