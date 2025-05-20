<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>QuantumTech | About</title>
  <link href="Styles/Styles.css" rel="stylesheet" />
  <style>
    /* Hero banner */
    header.hero {
      background-color: #0a0036; /* dark blue from your CSS */
      color: #fff;
      padding: 3rem 1rem;
      text-align: center;
      font-weight: 700;
      font-size: 2.8rem;
      letter-spacing: 1.5px;
    }

    main {
      max-width: 1000px;
      margin: 2rem auto;
      padding: 0 1rem;
      font-family: 'Poppins', sans-serif;
      color: #192753;
      line-height: 1.6;
    }

    section.team-info {
      margin-bottom: 3rem;
    }

    section.team-info h2 {
      border-bottom: 3px solid #6f6ff5; /* subtle accent */
      padding-bottom: 0.5rem;
      margin-bottom: 1.5rem;
      color: #0a0036;
    }

    ul.student-ids {
      list-style: none;
      padding-left: 0;
    }

    ul.student-ids li {
      margin-bottom: 0.5rem;
      font-weight: 600;
    }

    /* Team member cards container */
    .team-cards {
      display: flex;
      gap: 2rem;
      flex-wrap: wrap;
      justify-content: center;
    }

    /* Individual card */
    .team-card {
      background: #f0f0ff;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(25, 39, 83, 0.1);
      width: 280px;
      padding: 1.5rem 1rem 2rem;
      text-align: center;
      transition: transform 0.2s ease;
    }

    .team-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(25, 39, 83, 0.2);
    }

    .team-photo {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      background-color: #6f6ff5;
      margin: 0 auto 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 700;
      font-size: 3rem;
      user-select: none;
      box-shadow: 0 2px 6px rgba(25, 39, 83, 0.2);
    }

    .team-card h3 {
      margin-bottom: 0.3rem;
      color: #0a0036;
    }

    .team-card p.role {
      font-weight: 600;
      font-size: 0.9rem;
      color: #6f6ff5;
      margin-bottom: 1rem;
    }

    .team-card p.contribution {
      font-size: 0.9rem;
      color: #192753;
      text-align: left;
      white-space: pre-wrap;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .team-cards {
        flex-direction: column;
        align-items: center;
      }
      .team-card {
        width: 90%;
      }
    }
  </style>
</head>
<body>

<?php include 'header.inc'; ?>

<header class="hero">
  About Our Team
</header>

<main>
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
