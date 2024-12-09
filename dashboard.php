<?php 
session_start();
include '../includes/db_connect.php'; // Adjust the path as necessary
include '../includes/header.php'; // Adjust the path as necessary

// Check if the user is logged in and has an admin role
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];

// Fetch total number of admins
if ($role == 'admin') {
    $totalAdminsQuery = "SELECT COUNT(*) as total_admins FROM users WHERE role = 'admin'";
    $totalAdminsResult = mysqli_query($conn, $totalAdminsQuery);
    if (!$totalAdminsResult) {
        die("Query failed: " . mysqli_error($conn));
    }
    $totalAdmins = mysqli_fetch_assoc($totalAdminsResult)['total_admins'];

    // Fetch total number of customers
    $totalCustomersQuery = "SELECT COUNT(*) as total_customers FROM users WHERE role = 'customer'";
    $totalCustomersResult = mysqli_query($conn, $totalCustomersQuery);
    if (!$totalCustomersResult) {
        die("Query failed: " . mysqli_error($conn));
    }
    $totalCustomers = mysqli_fetch_assoc($totalCustomersResult)['total_customers'];
} else {
    $totalAdmins = null; // Set to null or some default value for customers
    $totalCustomers = null; // Set to null or some default value for customers
}

// Fetch total number of books
$totalBooksQuery = "SELECT COUNT(*) as total_books FROM books";
$totalBooksResult = mysqli_query($conn, $totalBooksQuery);
if (!$totalBooksResult) {
    die("Query failed: " . mysqli_error($conn));
}
$totalBooks = mysqli_fetch_assoc($totalBooksResult)['total_books'];

// Fetch total number of purchases (both roles)
$totalPurchasesQuery = "SELECT COUNT(*) as total_purchases FROM purchases";
$totalPurchasesResult = mysqli_query($conn, $totalPurchasesQuery);
if (!$totalPurchasesResult) {
    die("Query failed: " . mysqli_error($conn));
}
$totalPurchases = mysqli_fetch_assoc($totalPurchasesResult)['total_purchases'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        #sidebar {
            height: 100vh;
            position: fixed;
            background-color: #f8f9fa;
            padding-top: 31px;
        }

        #sidebar .nav-link {
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 10px;
        }

        #sidebar .nav-link.active {
            font-weight: bold;
            color: #007bff;
        }

        main {
            margin-left: 220px;
            padding: 20px;
        }

        h4 {
            margin-bottom: 20px;
        }

        .list-group-item {
            font-size: 1.1rem;
        }

        canvas {
            width: 100% !important;
            height: auto !important;
        }
    </style>
</head>
<body>
  <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-2 d-none d-md-block">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="books.php">Discover</a>
                    </li>
                    <?php if ($role == 'admin') { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="add_book.php">Enrich the Library</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="edit_book.php">Enhance the Catalog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="delete_books.php">Remove books</a>
                        </li>
                    <?php } ?>
                </ul>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?php echo ($role == 'admin') ? 'Admin Dashboard' : 'Customer Dashboard'; ?></h1>
                </div>

                <!-- Dashboard Statistics -->
                <div class="row">
                    <?php if ($role == 'admin') { ?>
                        <div class="col-md-3">
                            <div class="card text-white bg-info mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $totalAdmins; ?> Admins</h5>
                                    <p class="card-text">Manage Admins</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-primary mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $totalCustomers; ?> Customers</h5>
                                    <p class="card-text">Manage Customers</p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-md-3">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $totalBooks; ?> Books</h5>
                                <p class="card-text">Manage Books</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $totalPurchases; ?> Purchases</h5>
                                <p class="card-text">Books Purchased</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reading Activity -->
                <?php if ($role == 'admin') { ?>
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Total Reading Time</h4>
                            <canvas id="readingTimeChart"></canvas>
                        </div>
                        <div class="col-md-6">
                            <h4>Most Popular Times</h4>
                            <canvas id="popularTimesChart"></canvas>
                        </div>
                    </div>
                <?php } ?>

                <!-- Most Popular Novels -->
                <div class="mt-4">
                    <h4>Most Popular Novels</h4>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        Lake of Darkness
                            <span class="badge bg-primary rounded-pill">1500 Reads</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        Long Island
                            <span class="badge bg-primary rounded-pill">1200 Reads</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                        Sandwich
                            <span class="badge bg-primary rounded-pill">1000 Reads</span>
                        </li>
                    </ul>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Reading Time Chart (admin only)
        <?php if ($role == 'admin') { ?>
        const readingTimeCtx = document.getElementById('readingTimeChart').getContext('2d');
        const readingTimeChart = new Chart(readingTimeCtx, {
            type: 'bar',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Hours Read',
                    data: [2, 3, 1, 4, 3, 2, 5],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Popular Times Chart (admin only)
        const popularTimesCtx = document.getElementById('popularTimesChart').getContext('2d');
        const popularTimesChart = new Chart(popularTimesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Morning', 'Afternoon', 'Evening'],
                datasets: [{
                    label: 'Reading Times',
                    data: [25, 45, 30],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
        <?php } ?>
    </script>
</body>
</html>
