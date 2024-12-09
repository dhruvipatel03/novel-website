<?php include '../includes/header.php'; ?>
<?php
session_start();
include '../includes/db_connect.php'; // Adjust the path as necessary

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and retrieve form inputs
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    
    // Handle file upload
    $upload_dir = 'uploads/';
    $upload_file = '';

    // Ensure the upload directory exists
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) {
            die("Failed to create upload directory.");
        }
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $upload_file = $upload_dir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
            $upload_file = mysqli_real_escape_string($conn, $upload_file);
        } else {
            echo "<p>Error uploading image.</p>";
        }
    }

    // SQL query to insert the book into the database
    $sql = "INSERT INTO books (title, author, genre, price, image)
            VALUES ('$title', '$author', '$genre', '$price', '$upload_file')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Book added successfully.</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a New Book</title>
    <style>
        form{
            text-align: center;
            margin-top: 35px;
        }
        input{
            height: 50px;
            width: 20%;
            padding-left: 10px;
            font-size: 15px;
            border-radius: 6px;
        }
        .book-button{
            width: 200px;
            height: 50px;
            background-color: cadetblue;
            color: black;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center">Add a New Book</h2>
    <form method="post" action="add_book.php" enctype="multipart/form-data">
        <input type="text" name="title" id="title" placeholder="Enter title" required><br><br>

        <input type="text" name="author" id="author" placeholder="Author name" required><br><br>

        <input type="text" name="genre" id="genre" placeholder="Genre"><br><br>

        <input type="number" name="price" id="price" step="0.01" placeholder="Price" required><br><br>

        <label for="image">Image:</label>
        <input type="file" name="image" id="image"><br><br>

        <button class="book-button" type="submit">Add Book</button>
    </form>
</body>
</html>
