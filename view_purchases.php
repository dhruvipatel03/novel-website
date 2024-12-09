<?php
// Start session and include database connection
session_start();
include '../includes/db_connect.php'; // Adjust the path as necessary

// Check if the user is logged in and has a session
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in user's username
$username = $_SESSION['username'];

// Fetch the user's purchases from the database using the username
$purchases_sql = "SELECT p.id, b.title, p.purchase_date, b.price
                  FROM purchases p
                  JOIN books b ON p.book_id = b.id
                  WHERE p.user = ?";
$purchases_stmt = $conn->prepare($purchases_sql);

// Check if prepare() failed
if ($purchases_stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$purchases_stmt->bind_param("s", $username);
$purchases_stmt->execute();
$purchases_result = $purchases_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Purchases - Novel Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        .container {
            margin-top: 20px;
        }
        table {
            width: 100%;
        }
        th, td {
            text-align: left;
            padding: 10px;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        .btn {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Your Purchases</h1>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Purchase ID</th>
                            <th>Book Title</th>
                            <th>Purchase Date</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($purchases_result->num_rows > 0) {
                            while ($purchase = $purchases_result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($purchase['id']) . "</td>";
                                echo "<td>" . htmlspecialchars($purchase['title']) . "</td>";
                                echo "<td>" . htmlspecialchars($purchase['purchase_date']) . "</td>";
                                echo "<td>$" . number_format(htmlspecialchars($purchase['price']), 2) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No purchases found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <a href="customer_dashboard.php" class="btn">Back to Home</a>
            </div>
        </div>
    </div>
</body>
</html>
