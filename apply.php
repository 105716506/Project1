<head> <!--meta tags-->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keywords" content="HTML5, CSS layout, QuantumTech, Technology, Future, Website" />
  <meta name="description" content="Welcome to QuantumTech - Innovating the Future">
  <title>QuantumTech | Home</title> <!-- title of the website-->
  <link href="Styles/Styles.css" rel="stylesheet"> <!-- References to external CSS files -->
</head>

<body>
<!--php include of the header -->
<?php include 'header.inc'; ?>

<?php
require_once 'settings.php'; // Include database configuration settings

// Connect to the database
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch all jobs ordered by job reference
$sql = "SELECT * FROM jobs ORDER BY jobRef";
$result = mysqli_query($conn, $sql);


<main>
  <h1>Open Positions at QuantumTech</h1>

  <?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($job = mysqli_fetch_assoc($result)): ?>
      <section>
        <!-- Apply category class for potential styling based on category -->
        <div class="Engineer <?php echo htmlspecialchars($job['category']); ?>">
          <h2><?php echo htmlspecialchars($job['jobTitle']); ?></h2>
          <p><strong>Reference:</strong> <?php echo htmlspecialchars($job['jobRef']); ?></p>
          <p><strong>Salary Range:</strong> <?php echo htmlspecialchars($job['salaryRange']); ?></p>
          <p><strong>Reports to:</strong> <?php echo htmlspecialchars($job['reportsTo']); ?></p>

          <h3>Position Summary</h3>
          <!-- Convert line breaks to <br> for display -->
          <p><?php echo nl2br(htmlspecialchars($job['positionSummary'])); ?></p>

          <h3>Key Responsibilities</h3>
          <ul>
            <?php
              // Split the responsibilities string by new lines and list them
              $responsibilities = explode("\n", $job['keyResponsibilities']);
              foreach ($responsibilities as $resp) {
                echo '<li>' . htmlspecialchars(trim($resp)) . '</li>';
              }
            ?>
          </ul>

          <h3>Qualifications & Skills</h3>
          <ol>
            <?php
              // Split qualifications into sections and then into items
              $qualSections = explode("\n\n", trim($job['qualifications']));
              foreach ($qualSections as $section) {
                $lines = explode("\n", trim($section));
                if(count($lines) > 0) {
                  // Display the section title
                  echo '<li><strong>' . htmlspecialchars(array_shift($lines)) . '</strong><ul>';
                  // Display each qualification under that section
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
      <form action="process_eoi.php" method="post" novalidate="novalidate">
  <h2>Apply Now</h2>

  <label for="jobRef">Job Reference Number:</label>
  <select name="jobRef" id="jobRef" required>
    <?php
    // Reset pointer and loop jobs again to fill dropdown
    mysqli_data_seek($result, 0);
    while ($job = mysqli_fetch_assoc($result)) {
      echo "<option value='" . htmlspecialchars($job['jobRef']) . "'>" . htmlspecialchars($job['jobRef']) . " - " . htmlspecialchars($job['jobTitle']) . "</option>";
    }
    ?>
  </select><br><br>

  <label>First Name: <input type="text" name="firstName" maxlength="20" required></label><br>
  <label>Last Name: <input type="text" name="lastName" maxlength="20" required></label><br>
  <label>Date of Birth: <input type="text" name="dob" placeholder="dd/mm/yyyy" required></label><br>
  
  <fieldset>
    <legend>Gender:</legend>
    <label><input type="radio" name="gender" value="Male"> Male</label>
    <label><input type="radio" name="gender" value="Female"> Female</label>
    <label><input type="radio" name="gender" value="Other"> Other</label>
  </fieldset><br>

  <label>Street: <input type="text" name="street" maxlength="40" required></label><br>
  <label>Suburb/Town: <input type="text" name="suburb" maxlength="40" required></label><br>
  <label>State:
    <select name="state">
      <option value="VIC">VIC</option>
      <option value="NSW">NSW</option>
      <option value="QLD">QLD</option>
      <option value="NT">NT</option>
      <option value="WA">WA</option>
      <option value="SA">SA</option>
      <option value="TAS">TAS</option>
      <option value="ACT">ACT</option>
    </select>
  </label><br>

  <label>Postcode: <input type="text" name="postcode" maxlength="4" required></label><br>
  <label>Email: <input type="email" name="email" required></label><br>
  <label>Phone: <input type="text" name="phone" maxlength="12" required></label><br>

  <fieldset>
    <legend>Technical Skills</legend>
    <label><input type="checkbox" name="skills[]" value="Skill1"> HTML</label>
    <label><input type="checkbox" name="skills[]" value="Skill2"> CSS</label>
    <label><input type="checkbox" name="skills[]" value="Skill3"> JavaScript</label>
    <label><input type="checkbox" name="skills[]" value="Other"> Other</label>
  </fieldset>

  <label>Other Skills: <textarea name="otherSkills" rows="3" cols="30"></textarea></label><br><br>

  <button type="submit">Submit Application</button>
</form>

    <?php endwhile; ?>

    <!-- Additional info section -->
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

    <!-- Fun fact section -->
    <aside>
      <h3>Did You Know?</h3>
      <p>QuantumTech provides relocation support, remote work options, and generous health benefits to all our engineers!</p>
    </aside>

  <?php else: ?>
    <!-- If no jobs are available -->
    <p>No job listings available at the moment. Please check back later.</p>
  <?php endif; ?>

</main>

<?php
include 'footer.inc'; // Include the site footer
mysqli_close($conn); // Close the database connection
?>
