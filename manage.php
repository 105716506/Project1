<?php
// Start a new or resume an existing session
session_start();
// Include the database connection variables
include_once('settings.php');

// If user is not logged in, redirect to login page
if (!isset($_SESSION['manager_logged_in'])) {
    header("Location: login.php");
    exit;
}

// Connect to the MySQL database
$conn = mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    // If connection fails, show error and stop script
    die("Connection failed: " . mysqli_connect_error());
}

