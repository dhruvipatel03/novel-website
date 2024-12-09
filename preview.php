<?php
session_start();
include '../includes/db_connect.php'; // Adjust the path as necessary

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if the book ID is provided
if (isset($_GET['id'])) {
    $book_id = intval($_GET['id']);

    // Retrieve the book details
    $sql = "SELECT * FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $book = $result->fetch_assoc();

        // Check if the story exists
        if (!empty($book['story'])) {
            $story_exists = true;
        } else {
            $story_exists = false;
        }
    } else {
        echo "<p>Book not found.</p>";
        exit();
    }
} else {
    echo "<p>No book selected.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($book['title']); ?> - Preview</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 30px;
            color: #333;
            font-weight: bold;
        }
        .book-story {
            font-size: 1.2em;
            line-height: 1.6;
            color: #444;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 1em;
            color: #191970;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h1><?php echo htmlspecialchars($book['title']); ?> - Story</h1>
    
    <?php if ($story_exists): ?>
        <div class="book-story">
            <p><?php echo nl2br(htmlspecialchars($book['story'])); ?></p>
        </div>
    <?php else: ?>
        <div class="book-story">
            <p>Story not available for this book. You can search for a PDF version online:</p>
            <p><a href="https://www.google.com/search?q=<?php echo urlencode($book['title'] . ' PDF'); ?>" target="_blank">Search for PDF on Google</a></p>
        </div>
    <?php endif; ?>
    
    <a href="books.php" class="back-link">Back to All Books</a>
</div>

</body>
</html>
