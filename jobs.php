<?php
require_once 'settings.php';

$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM jobs ORDER BY jobRef";
$result = mysqli_query($conn, $sql);

include 'header.inc';
?>

<main>
  <h1>Open Positions at QuantumTech</h1>

  <?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($job = mysqli_fetch_assoc($result)): ?>
      <section>
        <div class="Engineer <?php echo htmlspecialchars($job['category']); ?>">
          <h2><?php echo htmlspecialchars($job['jobTitle']); ?></h2>
          <p><strong>Reference:</strong> <?php echo htmlspecialchars($job['jobRef']); ?></p>
          <p><strong>Salary Range:</strong> <?php echo htmlspecialchars($job['salaryRange']); ?></p>
          <p><strong>Reports to:</strong> <?php echo htmlspecialchars($job['reportsTo']); ?></p>

          <h3>Position Summary</h3>
          <p><?php echo nl2br(htmlspecialchars($job['positionSummary'])); ?></p>

          <h3>Key Responsibilities</h3>
          <ul>
            <?php
              $responsibilities = explode("\n", $job['keyResponsibilities']);
              foreach ($responsibilities as $resp) {
                echo '<li>' . htmlspecialchars(trim($resp)) . '</li>';
              }
            ?>
          </ul>

          <h3>Qualifications & Skills</h3>
          <ol>
            <?php
              $qualSections = explode("\n\n", trim($job['qualifications']));
              foreach ($qualSections as $section) {
                $lines = explode("\n", trim($section));
                if(count($lines) > 0) {
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

    <?php if (!empty($job['perks'])): ?>
    <section>
      <h3>Why Join Our Cloud Team?</h3>
      <p><?php echo nl2br(htmlspecialchars($job['perks'])); ?></p>
    </section>
    <?php endif; ?>

    <?php if (!empty($job['funFact'])): ?>
    <aside>
      <h3>Did You Know?</h3>
      <p><?php echo nl2br(htmlspecialchars($job['funFact'])); ?></p>
    </aside>
    <?php endif; ?>

  <?php else: ?>
    <p>No job listings available at the moment. Please check back later.</p>
  <?php endif; ?>

</main>

<?php
include 'footer.inc';
mysqli_close($conn);
?>
