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

