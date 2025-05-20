<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>QuantumTech | About</title>
  <link href="Styles/Styles.css" rel="stylesheet" />
</head>
<body>

<?php include 'header.inc'; ?>

<main>
  <h1 style="text-align:center; font-size:2.5rem; color:#0a0036; margin-bottom:2rem;">About Our Team</h1>

  <section class="team-info">
    <h2>Quantum Creators</h2>
    <p><strong>Class Time:</strong> Thursday, 12:30 PM – 2:30 PM</p>
    <p><strong>Tutor:</strong> Mr. Rahul Raghavan</p>
    <h3>Student IDs</h3>
    <ul class="student-ids">
      <li>Linuka Pulmeth Jayawardhana – 105713057</li>
      <li>Ramiru Hewavithana – 105716506</li>
      <li>Ibrahim Mohamed Irshad – 105929854</li>
    </ul>
  </section>

  <section class="team-info">
    <h2>Meet the Team</h2>
    <div class="team-cards">
      <?php
      $teamMembers = [
        [
          'initials' => 'LJ',
          'name' => 'Linuka Pulmeth Jayawardhana',
          'role' => 'Project Manager & Backend Developer',
          'contribution' => "• Developed process_eoi.php to securely process job applications.\n• Implemented server-side validation, sanitization, and dynamic EOI table creation.\n• Updated about.php and created dynamic job descriptions in jobs.php."
        ],
        [
          'initials' => 'RH',
          'name' => 'Ramiru Hewavithana',
          'role' => 'Lead Developer & Designer',
          'contribution' => "• Modularised site with reusable PHP includes for headers, footers, and nav.\n• Created settings.php for centralized database connection.\n• Designed and created the EOI MySQL table with comprehensive fields."
        ],
        [
          'initials' => 'IM',
          'name' => 'Ibrahim Mohamed Irshad',
          'role' => 'HR Management & Security Lead',
          'contribution' => "• Developed manage.php for HR to query, update, and delete EOIs.\n• Implemented user registration, login security, and access control.\n• Documented project and managed content quality."
        ],
      ];

      foreach ($teamMembers as $member) {
        echo '<div class="team-card">';
        echo '<div class="team-photo">' . htmlspecialchars($member['initials']) . '</div>';
        echo '<h3>' . htmlspecialchars($member['name']) . '</h3>';
        echo '<p class="role">' . htmlspecialchars($member['role']) . '</p>';
        echo '<p class="contribution">' . nl2br(htmlspecialchars($member['contribution'])) . '</p>';
        echo '</div>';
      }
      ?>
    </div>
  </section>

  <section class="team-info" style="text-align:center; margin-top:3rem;">
    <figure>
      <img src="Images/Profile pic.jpeg" alt="QuantumTech team photo" style="max-width:100%; border-radius:12px; box-shadow:0 4px 12px rgba(25,39,83,0.2);" />
      <figcaption style="margin-top:0.5rem; font-weight:600; color:#0a0036;">QuantumTech Team – Semester 1, 2025</figcaption>
    </figure>
  </section>
</main>

<?php include 'footer.inc'; ?>

</body>
</html>
