<?php
session_start();
include '../includes/db_connect.php'; // Adjust the path as necessary

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Initialize variables
$selected_genre = '';
$where_clause = '';

// Check if a genre is selected and set the WHERE clause
if (isset($_GET['genre']) && !empty($_GET['genre'])) {
    $selected_genre = $conn->real_escape_string($_GET['genre']);
    $where_clause = "WHERE genre = '$selected_genre'";
}

// Retrieve books from the database with an optional genre filter
$sql = "SELECT * FROM books $where_clause ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result === false) {
    echo "<p>Error fetching books: " . $conn->error . "</p>";
    $result = null; // Ensuring $result is null if the query fails
}

// Retrieve distinct genres for the dropdown
$genres_sql = "SELECT DISTINCT genre FROM books ORDER BY genre ASC";
$genres_result = $conn->query($genres_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Books</title>
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
        .search-genre {
            margin-bottom: 30px;
            text-align: center;
        }
        .search-genre form {
            display: inline-block;
            margin-bottom: 20px;
        }
        .search-genre select {
            padding: 10px;
            font-size: 1.2em;
            border-radius: 10px;
            border: 1px solid #ccc;
            width: 200px;
        }
        .search-genre button {
            padding: 10px 20px;
            font-size: 1.2em;
            border-radius: 10px;
            background-color: #191970;
            color: white;
            border: none;
            cursor: pointer;
            margin-left: 10px;
            transition: background-color 0.3s;
        }
        .search-genre button:hover {
            background-color: #444;
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
        .book-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        /* Button Styling */
        .book-buttons a {
            padding: 10px 20px;
            font-size: 1em;
            color: white;
            text-decoration: none;
            text-align: center;
            border-radius: 25px;
            box-shadow: 0px 8px 12px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
            display: inline-block;
            min-width: 90px;
            max-width: 150px;
            width: auto;
        }
        .book-buttons a:hover {
            transform: translateY(-3px);
            box-shadow: 0px 12px 15px rgba(0, 0, 0, 0.25);
        }
        .preview {
            background-color: #008080;
        }
        .buy {
            background-color: #BC8F8F;
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

<h1 style="color:#191970">All Books</h1>

<div class="container">
    <div class="search-genre">
        <form action="books.php" method="get">
            <select name="genre">
                <option value="">All Genres</option>
                <?php
                if ($genres_result && $genres_result->num_rows > 0) {
                    while ($genre_row = $genres_result->fetch_assoc()) {
                        $selected = ($genre_row['genre'] == $selected_genre) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($genre_row['genre']) . '" ' . $selected . '>' . htmlspecialchars($genre_row['genre']) . '</option>';
                    }
                }
                ?>
            </select>
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="book-list">
        <?php
        if ($result && $result->num_rows > 0) {
            // Output data for each book
            while ($row = $result->fetch_assoc()) {
                echo '<div class="book-item">';
                if (!empty($row['image'])) {
                    echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['title']) . '" class="book-image">';
                }
                echo '<div class="book-title">' . htmlspecialchars($row['title']) . '</div>';
                echo '<div class="book-author">by ' . htmlspecialchars($row['author']) . '</div>';
                echo '<div class="book-genre">Genre: ' . htmlspecialchars($row['genre']) . '</div>';
                echo '<div class="book-price">$' . htmlspecialchars($row['price']) . '</div>';
                echo '<div class="book-buttons">';
                echo '<a href="preview.php?id=' . htmlspecialchars($row['id']) . '" class="preview">Preview</a>';
                echo '<a href="buy.php?id=' . htmlspecialchars($row['id']) . '" class="buy">Buy</a>';
                echo '</div>'; // .book-buttons
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
