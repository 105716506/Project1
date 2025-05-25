<head> <!--meta tags-->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keywords" content="HTML5, CSS layout, QuantumTech, Technology, Future, Website" />
  <meta name="description" content="Welcome to QuantumTech - Innovating the Future">
  <title>QuantumTech | Home</title> <!-- title of the website-->
  <link href="Styles/Styles.css" rel="stylesheet"> <!-- References to external CSS files -->
</head>

<body>
// Include database settings
<?php
require_once 'settings.php';

// Attempt to connect to the database
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    // Display error message if connection fails
    die("Database connection failed: " . mysqli_connect_error());
}

// SQL query to fetch all job listings, ordered by job reference
$sql = "SELECT * FROM jobs ORDER BY jobRef";
$result = mysqli_query($conn, $sql);

// Include the page header
include 'header.inc';
?>

<main>
  <h1>Open Positions at QuantumTech</h1>

  <?php if (mysqli_num_rows($result) > 0): ?>
    <!-- Loop through each job and display its details -->
    <?php while ($job = mysqli_fetch_assoc($result)): ?>
      <section>
        <!-- Add class based on job category for styling -->
        <div class="Engineer <?php echo htmlspecialchars($job['category']); ?>">
          <h2><?php echo htmlspecialchars($job['jobTitle']); ?></h2>
          <p><strong>Reference:</strong> <?php echo htmlspecialchars($job['jobRef']); ?></p>
          <p><strong>Salary Range:</strong> <?php echo htmlspecialchars($job['salaryRange']); ?></p>
          <p><strong>Reports to:</strong> <?php echo htmlspecialchars($job['reportsTo']); ?></p>

          <h3>Position Summary</h3>
          <!-- Convert line breaks to <br> and escape special characters -->
          <p><?php echo nl2br(htmlspecialchars($job['positionSummary'])); ?></p>

          <h3>Key Responsibilities</h3>
          <ul>
            <?php
              // Split responsibilities by line and display each as a list item
              $responsibilities = explode("\n", $job['keyResponsibilities']);
              foreach ($responsibilities as $resp) {
                echo '<li>' . htmlspecialchars(trim($resp)) . '</li>';
              }
            ?>
          </ul>

          <h3>Qualifications & Skills</h3>
          <ol>
            <?php
              // Split qualifications into sections by double line breaks
              $qualSections = explode("\n\n", trim($job['qualifications']));
              foreach ($qualSections as $section) {
                $lines = explode("\n", trim($section));
                if(count($lines) > 0) {
                  // First line is section title; remaining lines are bullet points
                  echo '<li><strong>' . htmlspecialchars(array_shift($lines)) . '</strong><ul>';
                  foreach ($lines as $line) {
                    echo '<li>' . htmlspecialchars(trim($line)) . '</li>';
                  }
                  echo '</ul></li>';
                }
              }
            ?>
          </ol>
        </div>
      </section>
    <?php endwhile; ?>

    <!-- Section promoting cloud team benefits -->
    <section>
      <h3>Why Join Our Cloud Team?</h3>
      <p>At QuantumTech, you’ll be working with the most advanced cloud technologies in an inclusive and growth-oriented environment:</p>
      <ul>
        <li>🏆 Award-winning cloud projects</li>
        <li>🌐 Global-scale infrastructure solutions</li>
        <li>📈 Paid certifications and training programs</li>
        <li>💡 Hackathons and innovation sprints</li>
      </ul>
    </section>

    <!-- Sidebar with additional company perks -->
    <aside>
      <h3>Did You Know?</h3>
      <p>QuantumTech provides relocation support, remote work options, and generous health benefits to all our engineers!</p>
    </aside>

  <?php else: ?>
    <!-- Message shown if no jobs are found -->
    <p>No job listings available at the moment. Please check back later.</p>
  <?php endif; ?>
</main>

<?php
// Include the page footer and close database connection
include 'footer.inc';
mysqli_close($conn);
?>
