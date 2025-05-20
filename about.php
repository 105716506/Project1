<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="About our group at QuantumTech" />
  <title>QuantumTech | About</title>

  <!-- External stylesheet link -->
  <link href="Styles/Styles.css" rel="stylesheet" />
</head>

<body>
<?php include 'header.inc'; ?>

<main>
  <h1>About Our Team</h1>

  <section>
    <h2>Team Details</h2>
    <ul>
      <li>Group Name: Quantum Creators</li>
      <li>Class Time: Thursday, 12:30 PM – 2:30 PM</li>
      <li>Tutor: Mr. Rahul Raghavan</li>
      <li>Student IDs:
        <ul class="student-ids">
          <li>Linuka Pulmeth Jayawardhana (Project Manager & Container) – 105713057</li>
          <li>Ramiru Hewavithana (Lead Developer) – 105716506</li>
          <li>Ibrahim Mohamed Irshad (Content & Documentation) – 105929854</li>
        </ul>
      </li>
    </ul>
  </section>

  <section>
    <h2>Contributions</h2>
    <dl>
      <dt><strong>Linuka Pulmeth Jayawardhana</strong></dt>
      <dd>
        <p>Led the development of server-side form processing by creating <code>process_eoi.php</code> which validates and adds expression of interest (EOI) records into the database.</p>
        <p>Implemented robust server-side validation, sanitization of user input, and dynamic table creation to ensure data integrity and security.</p>
        <p>Updated <code>about.php</code> to reflect team contributions, and developed dynamic job descriptions by creating and populating the <code>jobs</code> table in the database and dynamically generating HTML content in <code>jobs.php</code>.</p>
      </dd>

      <dt><strong>Ramiru Hewavithana</strong></dt>
      <dd>
        <p>Modularised the website by creating reusable components such as headers, footers, and navigation menus with PHP include files (<code>.inc</code>), improving maintainability and consistency.</p>
        <p>Developed the database connection file <code>settings.php</code> for secure and centralized management of database credentials.</p>
        <p>Designed and created the <code>eoi</code> table structure in MySQL to store applicant data with appropriate fields and status management.</p>
      </dd>

      <dt><strong>Ibrahim Mohamed Irshad</strong></dt>
      <dd>
        <p>Developed the HR management interface <code>manage.php</code> to enable querying, updating, deleting, and sorting of EOI records, providing essential administrative controls.</p>
        <p>Implemented additional enhancements including user registration with server-side validation, login security, and access control mechanisms to protect sensitive pages.</p>
        <p>Handled project documentation and coordinated content updates to ensure quality and clarity throughout the website.</p>
      </dd>
    </dl>
  </section>

  <section>
    <figure>
      <img src="Images/Profile pic.jpeg" alt="QuantumTech team photo" width="800" height="800" />
      <figcaption>QuantumTech Team – Semester 1, 2025</figcaption>
    </figure>
  </section>

  <section>
    <h2>Our Team</h2>
    <table>
      <caption>Our Interests</caption>
      <thead>
        <tr>
          <th>Name</th>
          <th>Programming Languages</th>
          <th>Hobbies</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Linuka</td>
          <td>HTML, CSS, JavaScript</td>
          <td>Music, Chess</td>
        </tr>
        <tr>
          <td>Ramiru</td>
          <td>Python, SQL</td>
          <td>Gaming, Cycling</td>
        </tr>
        <tr>
          <td>Ibrahim</td>
          <td>Java, PHP</td>
          <td>Photography, Reading</td>
        </tr>
      </tbody>
    </table>
  </section>
</main>

<?php include 'footer.inc'; ?>

</body>
</html>
