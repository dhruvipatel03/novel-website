<?php
// Start session and include database connection
session_start();
include '../includes/db_connect.php'; // Adjust the path as necessary

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $user['role']; // Store role in session

                // Redirect to the appropriate dashboard based on the role
                if ($user['role'] == 'admin') {
                    header("Location: dashboard.php");
                } else {
                    header("Location: customer_dashboard.php");
                }
                exit();
            } else {
                $error = "Invalid username or password";
            }
        } else {
            $error = "Invalid username or password";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novelwebsite</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            height: 100%;
            background-color: #1a1a1a;
            background-image: url("../images/backimg.jpg");
            background-size: cover;
            background-position: center;
        }
        .header {
            position: relative;
            z-index: 1;
        }
        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 80px); /* Adjust height to prevent overlap with header */
        }
        .welcome-back {
            flex: 1;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            text-align: center;
            max-width: 400px;
            width: 100%;
            padding: 145px 40px;
            border-radius: 10px 0 0 10px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
        }
        .welcome-back h3 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        .welcome-back p {
            font-size: 18px;
        }
        .login-container {
            flex: 1;
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 0 10px 10px 0;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .login-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .login-container input {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .login-container button {
            width: 100%;
            padding: 15px;
            margin: 20px 0;
            background-color: #00BFFF;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            color: white;
            cursor: pointer;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
        }
        .login-container button:hover {
            background-color: #009ACD;
        }
        .login-container a {
            display: block;
            margin-top: 10px;
            color: #009ACD;
            text-decoration: none;
            font-size: 14px;
        }
        .login-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="header">
    <?php include '../includes/header.php'; ?>
</div>
<div class="login-wrapper">
    <div class="welcome-back">
        <h3>Welcome Back</h3>
        <p>Please log in using your personal information to stay connected with us.</p>
    </div>
    <div class="login-container">
        <h2>Login</h2>
        <form method="post" action="">
            <input type="text" id="username" name="username" placeholder="Username" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <a href="#">Forgot password?</a>
            <a href="register.php">Don't have an account? Signup</a>
        </form>
    </div>
</div>
</body>
</html>
