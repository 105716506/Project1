<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>QuantumTech | Apply</title>
  <link href="Styles/Styles.css" rel="stylesheet" />
</head>
<body></body>
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

// Initialize message string for feedback display
$message = "";

// Handle POST form submissions (deleting or updating EOIs)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Deleting EOIs by Job Reference Number
    if (isset($_POST['delete_job_ref'])) {
        $jobRef = mysqli_real_escape_string($conn, $_POST['delete_job_ref']);
        $sql = "DELETE FROM eoi WHERE job_reference_number = '$jobRef'";
        mysqli_query($conn, $sql);
        $message = "All EOIs with job reference $jobRef deleted.";
    }

    // Updating EOI status
    if (isset($_POST['update_status']) && isset($_POST['eoi_number']) && isset($_POST['new_status'])) {
        $eoi = intval($_POST['eoi_number']);
        $status = mysqli_real_escape_string($conn, $_POST['new_status']);
        $sql = "UPDATE eoi SET status = '$status' WHERE EOInumber = $eoi";
        mysqli_query($conn, $sql);
        $message = "EOI #$eoi status updated to $status.";
    }
}
// Get sorting field from GET request, default to EOInumber
$sort_field = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'EOInumber';
// Define which fields are safe to sort by
$valid_sort_fields = ['EOInumber', 'first_name', 'last_name', 'status'];
// If the user gave an invalid field, use default
if (!in_array($sort_field, $valid_sort_fields)) $sort_field = 'EOInumber';

// Build filter conditions based on GET request
$where = "1=1";  // default condition that always returns true

