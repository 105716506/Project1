<head> <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keywords" content="QuantumTech, Technology, Future, Website, Cloud, Engineer, FrontEnd, Developer, Data, Analyst, Jobs, Apply, Salary, Careers" />
  <meta name="description" content="Welcome to QuantumTech - Innovating the Future">
  <title>QuantumTech | Manage</title> <!-- title of the website-->
  <link href="Styles/Styles.css" rel="stylesheet"> <!-- References to external CSS files -->
</head>

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

// If job reference is provided, filter by it
if (isset($_GET['job_ref']) && $_GET['job_ref'] != "") {
    $jobRef = mysqli_real_escape_string($conn, $_GET['job_ref']);
    $where .= " AND job_reference_number = '$jobRef'";
}

// If first name is provided, filter by it
if (!empty($_GET['first_name'])) {
    $fn = mysqli_real_escape_string($conn, $_GET['first_name']);
    $where .= " AND first_name LIKE '%$fn%'";
}

// If last name is provided, filter by it
if (!empty($_GET['last_name'])) {
    $ln = mysqli_real_escape_string($conn, $_GET['last_name']);
    $where .= " AND last_name LIKE '%$ln%'";
}

// Build the final SQL query with WHERE and ORDER BY
$sql = "SELECT * FROM eoi WHERE $where ORDER BY $sort_field";

// Run the query and store results
$result = mysqli_query($conn, $sql);
?>

<body>
<!--php include of the header -->
<?php include 'header.inc';?>

<?php if (isset($_SESSION['manager_username'])): ?>
    <div class="manager-username">
        Logged in as: <span><?= htmlspecialchars($_SESSION['manager_username']); ?></span>
    </div>
<?php endif; ?>

    <main>
        <h2>Manage EOIs</h2>

        <!-- Display any success or feedback messages -->
        <?php if ($message): ?>
            <div class="success"><?= $message ?></div>
        <?php endif; ?>


        <!-- Filter/Search Form -->
        <form class="manager-sort-form" method="get" action="manage.php">
            <label>Job Reference: <input type="text" name="job_ref" /></label>
            <label>First Name: <input type="text" name="first_name" /></label>
            <label>Last Name: <input type="text" name="last_name" /></label>
            <label>Sort by:
                <select name="sort_by">
                    <option value="EOInumber">EOI Number</option>
                    <option value="first_name">First Name</option>
                    <option value="last_name">Last Name</option>
                    <option value="status">Status</option>
                </select>
            </label>
            <input type="submit" value="Filter / Sort">
        </form>

        <!-- Delete EOIs by Job Reference Form -->
        <form class="manager-form" method="post" action="manage.php" onsubmit="return confirm('Are you sure you want to delete?');">
            <label>Delete EOIs with Job Ref: <input type="text" name="delete_job_ref" required /></label>
            <input type="submit" value="Delete">
        </form>

        <!-- Display EOIs in a table -->
        <table class="manager-table">
            <tr>
                <th>EOI#</th><th>Job Ref</th><th>First Name</th><th>Last Name</th>
                <th>Email</th><th>Phone</th><th>Status</th><th>Update Status</th>
            </tr>
            <!-- Loop through each EOI and show in the table -->   
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['EOInumber'] ?></td>
                <td><?= $row['job_reference_number'] ?></td>
                <td><?= $row['first_name'] ?></td>
                <td><?= $row['last_name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['phone'] ?></td>
                <td><?= $row['status'] ?></td>
                <td>
                    <!-- Form to update status of individual EOI -->
                    <form class="manager-form" method="post" action="manage.php">
                        <input type="hidden" name="eoi_number" value="<?= $row['EOInumber'] ?>">
                        <select name="new_status">
                            <option value="New">New</option>
                            <option value="Current">Current</option>
                            <option value="Final">Final</option>
                        </select>
                        <input type="submit" name="update_status" value="Update">
                    </form>
                </td>
            </tr>

            <?php endwhile; ?>
        </table>

        <?php if (isset($_SESSION['manager_logged_in'])): ?>
            <a href="logout.php" class="logout-link">Logout</a>
        <?php endif; ?>

    </main>
</body>
</html>
