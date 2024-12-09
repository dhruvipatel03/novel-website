<?php
session_start();
include '../includes/db_connect.php'; // Adjust the path as necessary

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Retrieve all books from the database
$sql = "SELECT * FROM books ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result === false) {
    echo "<p>Error fetching books: " . $conn->error . "</p>";
    $result = null; // Ensuring $result is null if the query fails
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Books</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
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
        .book-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-around;
        }
        .book-item {
            background-color: #f9f9f9;
            border-radius: 16px;
            padding: 20px;
            width: calc(25% - 40px);
            text-align: center;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
        }
        .book-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
        .book-title {
            font-size: 1.4em;
            margin: 10px 0;
            color: #444;
            font-weight: bold;
        }
        .book-author {
            font-size: 1.1em;
            color: #666;
        }
        .book-genre {
            font-size: 1em;
            color: #888;
        }
        .book-price {
            margin-top: 15px;
            font-size: 1.2em;
            color: #27ae60;
            font-weight: bold;
        }
        .book-image {
            width: 100%;
            height: auto;
            max-height: 200px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 15px;
        }
        .delete-button {
            background-color:#4682B4;
            color: white;
            border: none;
            margin-top: 23px; /* Adjust margin-top as needed */
            padding: 12px 30px;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            font-size: 20px;
            transition: background-color 0.3s, transform 0.3s;
            display: inline-block;
        }
        .delete-button:hover {
            background-color: #c0392b;
            transform: scale(1.05);
        }

        /* Responsive adjustments */
        @media (max-width: 1200px) {
            .book-item {
                width: calc(33.33% - 40px); /* 3 items per row */
            }
        }

        @media (max-width: 900px) {
            .book-item {
                width: calc(50% - 40px); /* 2 items per row */
            }
        }

        @media (max-width: 600px) {
            .book-item {
                width: 100%; /* 1 item per row */
            }
            .book-image {
                max-height: 180px; /* Adjust image height for smaller screens */
            }
        }
    </style>
</head>
<body>

<h1>Delete Books</h1>

<div class="container">
    <div class="book-list">
        <?php
        if ($result && $result->num_rows > 0) {
            // Output data for each book
            while($row = $result->fetch_assoc()) {
                echo '<div class="book-item">';
                if (!empty($row['image'])) {
                    echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['title']) . '" class="book-image">';
                }
                echo '<div class="book-title">' . htmlspecialchars($row['title']) . '</div>';
                echo '<div class="book-author">by ' . htmlspecialchars($row['author']) . '</div>';
                echo '<div class="book-genre">Genre: ' . htmlspecialchars($row['genre']) . '</div>';
                echo '<div class="book-price">$' . htmlspecialchars($row['price']) . '</div>';
                echo '<a href="delete.php?id=' . htmlspecialchars($row['id']) . '" class="delete-button">Delete</a>';
                echo '</div>'; // .book-item
            }
        } else {
            echo '<p>No books found.</p>';
        }
        ?>
    </div>
</div>

</body>
</html>
