<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the homepage or login page
header("Location:/novelwebsite/pages/login.php");
exit();