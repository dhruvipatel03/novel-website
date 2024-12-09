<?php include '../includes/header.php'; ?>
<?php
session_start();
include '../includes/db_connect.php'; // Adjust the path as necessary

// Check if the user is logged in and has a customer role
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'customer') {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'] ?? 'Guest';
$hour = date('H');

if ($hour < 12) {
    $greeting = "Good Morning";
} elseif ($hour < 18) {
    $greeting = "Good Afternoon";
} else {
    $greeting = "Good Evening";
}

$welcomeMessage = "$greeting, " . htmlspecialchars($username) . "!";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #sidebar {
            height: 100vh;
            position: fixed;
            background-color: #f8f9fa;
            padding-top: 30px;
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

        #recommendations {
            margin-top: 30px;
        }

        .card {
            margin-bottom: 20px;
        }

        .card-img-top {
            max-height: 200px;
            width: auto;
            object-fit: cover;
            display: block;
            margin: 0 auto; /* Center the image horizontally */
        }

        .img-container {
            height: 200px; /* Set a fixed height */
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
        }
        .mt-4{
            margin-bottom: 100px;
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
                        <a class="nav-link active" href="customer_dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_purchases.php">View Purchases</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="books.php">Discover</a>
                    </li>
                </ul>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 style="color:dodgerblue"><?php echo $welcomeMessage;?></h1>
                </div>

                <!-- Book Recommendations -->
                <div id="recommendations" class="row">
                    <h4>Recommended for You</h4>
                    <!-- Example recommendation cards -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="img-container">
                                <img src="../images/nov3.jpg" class="card-img-top" alt="Book 1">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Lake of darkness</h5>
                                <p class="card-text">A thrilling mystery novel that keeps you guessing.</p>
                                <a href="books.php" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="img-container">
                                <img src="../images/nov1.jpg" class="card-img-top" alt="Book 2">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"> Grown women</h5>
                                <p class="card-text">An intimate, powerful, and inspiring memoir by the former First Lady of the United States.</p>
                                <a href="books.php" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reading Progress -->
                <div class="mt-4">
                    <h4>Your Reading Progress</h4>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            "To Kill a Mockingbird"
                            <div class="progress w-50">
                                <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            "1984"
                            <div class="progress w-50">
                                <div class="progress-bar" role="progressbar" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">40%</div>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Recent Activity -->
                <div class="mt-4">
                    <h4>Your Recent Activity</h4>
                    <ul class="list-group">
                        <li class="list-group-item">You viewed "Pride and Prejudice" on 09/01/2024</li>
                        <li class="list-group-item">You purchased "The Catcher in the Rye" on 08/30/2024</li>
                    </ul>
                </div>
            </main>
        </div>
    </div>
</body>
</html>