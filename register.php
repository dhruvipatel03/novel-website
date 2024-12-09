<?php
// Include database connection
include '../includes/db_connect.php'; // Adjust the path as necessary

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data and escape it to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Validate that all fields are filled
    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        $error = "All fields are required.";
    } else {
        // Check if the email or username already exists
        $check_sql = "SELECT * FROM users WHERE email='$email' OR username='$username'";
        $check_result = $conn->query($check_sql);

        if ($check_result === false) {
            // SQL error
            $error = "Error executing query: " . $conn->error;
        } elseif ($check_result->num_rows > 0) {
            // User already exists
            $error = "Username or email already exists.";
        } else {
            // Hash the password before storing
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database with the selected role
            $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashed_password', '$role')";

            if ($conn->query($sql) === TRUE) {
                // Redirect to the login page after successful registration
                header("Location: login.php");
                exit();
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Novelwebsite</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url("../images/backimg.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .register-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            padding: 20px 40px;
            width: 400px;
            max-width: 100%;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .register-container input[type="text"],
        .register-container input[type="email"],
        .register-container input[type="password"],
        .register-container select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .register-container button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        .register-container button:hover {
            background-color: #0056b3;
        }

        .register-container p {
            margin-top: 20px;
            color: #333;
        }

        .register-container p a {
            color: #007BFF;
            text-decoration: none;
        }

        .register-container p a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Create Your Account</h2>

        <?php if (isset($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>

        <form method="post" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="customer">Customer</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit">Sign Up</button>
        </form>

        <p>Already have an account? <a href="login.php">Log In</a></p>
    </div>
</body>
</html>
