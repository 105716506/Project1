<?php
require_once 'settings.php';

// Connect to database
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch all jobs
$sql = "SELECT jobRef, jobTitle, jobDescription FROM jobs ORDER BY jobRef";
$result = mysqli_query($conn, $sql);

include 'header.inc';
include 'nav.inc'; // if you have a navigation include

?>

<main>
  <h1>Available Job Positions</h1>

  <?php if (mysqli_num_rows($result) > 0): ?>
    <section class="job-listings">
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <article class="job-posting">
          <h2><?php echo htmlspecialchars($row['jobTitle']); ?> (<?php echo htmlspecialchars($row['jobRef']); ?>)</h2>
          <p><?php echo nl2br(htmlspecialchars($row['jobDescription'])); ?></p>
        </article>
      <?php endwhile; ?>
    </section>
  <?php else: ?>
    <p>No job listings available at the moment. Please check back later.</p>
  <?php endif; ?>

</main>

<?php
include 'footer.inc';
mysqli_close($conn);
?>
