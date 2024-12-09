<?php
session_start();
include '../includes/db_connect.php'; // Adjust the path as necessary

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Delete the book from the database
    $sql = "DELETE FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);

    if ($stmt->execute()) {
        // If delete was successful, redirect to the books.php page
        header("Location: books.php");
        exit();
    } else {
        echo "<p>Error deleting book: " . $conn->error . "</p>";
    }

    $stmt->close();
}

$conn->close();
?>
