<?php
// --- ENHANCEMENT: Manager login protection and account lockout (handled in login.php) ---
session_start();

// If user is not logged in, redirect to login page
if (!isset($_SESSION['manager_logged_in']) || !$_SESSION['manager_logged_in']) {
    header("Location: login.php");
    exit;
}

// --- END enhancement for session-based manager access ---

// Include the database connection variables
include_once('settings.php');

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

// --- ENHANCEMENT: Manager can select sorting field for EOIs ---
// Define which fields are safe to sort by (add more as needed, match your DB columns)
$valid_sort_fields = ['EOInumber', 'first_name', 'last_name', 'status', 'job_reference_number'];

// Get sorting field from GET request, default to EOInumber
$sort_field = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'EOInumber';

// If the user gave an invalid field, use default
if (!in_array($sort_field, $valid_sort_fields)) $sort_field = 'EOInumber';
// --- END sorting enhancement ---

// Build filter conditions based on GET request
$where = "1=1";  // default condition that always returns true

// [YOUR EXISTING FILTER AND QUERY LOGIC CONTINUES HERE]

// --- Enhancement: Sort EOIs by field (add a dropdown above the EOIs table) ---
?>
<!-- Manager Sorting Dropdown (Enhancement) -->
<form method="get" action="manage.php" style="margin-bottom: 1em;">
    <label for="sort_by"><strong>Sort EOIs by:</strong></label>
    <select name="sort_by" id="sort_by">
        <option value="EOInumber" <?php if($sort_field == 'EOInumber') echo 'selected'; ?>>EOI Number</option>
        <option value="job_reference_number" <?php if($sort_field == 'job_reference_number') echo 'selected'; ?>>Job Reference</option>
        <option value="first_name" <?php if($sort_field == 'first_name') echo 'selected'; ?>>First Name</option>
        <option value="last_name" <?php if($sort_field == 'last_name') echo 'selected'; ?>>Last Name</option>
        <option value="status" <?php if($sort_field == 'status') echo 'selected'; ?>>Status</option>
    </select>
    <input type="submit" value="Sort">
</form>
<!-- END Enhancement: Sorting Dropdown -->

<?php
// --- ENHANCEMENT: Use the sort field in your main EOIs query ---
$sql = "SELECT * FROM eoi WHERE $where ORDER BY $sort_field";
// Execute the query as usual...
// $result = mysqli_query($conn, $sql);
// [YOUR EXISTING CODE TO OUTPUT THE EOIs TABLE/LIST FOLLOWS]

// --- Manager-Only Features ---
// The features for updating/deleting EOIs below are restricted to logged-in managers by the session check at the top of this file.

// --- Enhancements Reference ---
// 1. Manager registration with server-side validation and unique username/password is handled in register_manager.php
// 2. Manager login and account lockout (after 3 failed attempts) are handled in login.php
// 3. Manager access control is enforced at the top of this page (session-based login check).
// 4. Sorting EOIs by any field is available via the dropdown above.

?>
