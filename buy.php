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

        // Process the purchase (this is just a placeholder for demonstration purposes)
        // In a real-world scenario, you would add payment processing, etc.
        $user = $_SESSION['username'];
        $purchase_sql = "INSERT INTO purchases (user, book_id) VALUES (?, ?)";
        $purchase_stmt = $conn->prepare($purchase_sql);
        $purchase_stmt->bind_param("si", $user, $book_id);

        if ($purchase_stmt->execute()) {
            // Purchase was successful
            $success = true;
        } else {
            // Failed to log purchase
            $success = false;
            $error = $conn->error;
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
    <title>Purchase Confirmation</title>
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
            text-align: center;
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 30px;
            color: #27ae60;
        }
        p {
            font-size: 1.2em;
            margin-bottom: 20px;
            color: #444;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            font-size: 1em;
            color: #191970;
            text-decoration: none;
            border: 1px solid #191970;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        .back-link:hover {
            background-color: #191970;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <?php if (isset($success) && $success): ?>
        <h1>Purchase Successful!</h1>
        <p>Thank you for purchasing <strong><?php echo htmlspecialchars($book['title']); ?></strong>.</p>
    <?php else: ?>
        <h1>Purchase Failed</h1>
        <p>Sorry, there was an issue processing your purchase.</p>
        <?php if (isset($error)): ?>
            <p>Error: <?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    <?php endif; ?>
    
    <a href="books.php" class="back-link">Back to All Books</a>
</div>

</body>
</html>
