<?php include '../includes/header.php'; ?>
<?php
session_start();
include '../includes/db_connect.php'; // Adjust the path as necessary

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$book = null; // Initialize variable to hold book details

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and retrieve form inputs
    $id = intval($_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // Handle file upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/../uploads/'; // Absolute path to uploads directory
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $upload_file = $upload_dir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
            $image = mysqli_real_escape_string($conn, $upload_file);
        } else {
            echo "<p>Error uploading image.</p>";
        }
    }
    // SQL query to update the book in the database
    $sql = "UPDATE books SET title='$title', author='$author', genre='$genre', price='$price'";
    if ($image) {
        $sql .= ", image='$image'";
    }
    $sql .= " WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: books.php");
        exit();
    } else {
        echo "<p>Error updating book: " . $conn->error . "</p>";
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM books WHERE id = $id LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        echo "<p>Book not found.</p>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .edit-form {
            width: 300px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .edit-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .edit-form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .edit-form input[type="text"], .edit-form input[type="number"], .edit-form input[type="file"], .edit-form button {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .edit-form button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit-form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="edit-form">
        <h2>Edit Book</h2>
        <?php if (!$book): ?>
            <form method="get" action="" enctype="multipart/form-data">
                <label for="id">Enter Book ID:</label>
                <input type="number" name="id" id="id" required>
                <button type="submit">Fetch Book Details</button>
            </form>
        <?php else: ?>
            <form method="post" action="" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($book['id']); ?>">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>

                <label for="author">Author:</label>
                <input type="text" name="author" id="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>

                <label for="genre">Genre:</label>
                <input type="text" name="genre" id="genre" value="<?php echo htmlspecialchars($book['genre']); ?>">

                <label for="price">Price:</label>
                <input type="number" name="price" id="price" step="0.01" value="<?php echo htmlspecialchars($book['price']); ?>" required>

                <label for="image">Image:</label>
                <?php if (!empty($book['image'])): ?>
                    <img src="<?php echo htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>" style="width: 100px; height: auto; margin-bottom: 10px;">
                <?php endif; ?>
                <input type="file" name="image" id="image">

                <button type="submit">Update Book</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
