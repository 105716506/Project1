<?php
// enhancements.php - QuantumTech Project Enhancements
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enhancements | QuantumTech Project</title>
    <link href="Styles/Styles.css" rel="stylesheet">
</head>
<body>
    <?php include 'header.inc'; ?>
    <main>
        <section class="manager-form" style="max-width:750px;">
            <h1>Project Enhancements</h1>

            <h2>1. Sorting EOI Records by Field</h2>
            <p>
                To improve usability for managers, we added a sorting feature on the EOI management page (<strong>manage.php</strong>). <br>Managers can choose from a dropdown menu which field they would like to sort EOI records by: EOI Number, First Name, Last Name, or Status. <br>When the manager selects a field and submits, the page reloads with the EOI records ordered according to the chosen field. This is handled securely in PHP by allowing only pre-approved fields to be used in the SQL <code>ORDER BY</code> clause, preventing any risk of SQL injection. <br>This enhancement helps managers quickly find, prioritize, and review applications as needed.
            </p>

            <h2>2. Manager Registration with Server-Side Validation</h2>
            <p>
                We implemented a manager registration page that allows new managers to securely create accounts. <br>The registration process includes strict server-side validation: usernames must be unique, and passwords must be at least eight characters long and include both letters and numbers. <br>This ensures all managers have strong, non-guessable passwords. Passwords are hashed before storage using <code>password_hash()</code>, and all inputs are validated in PHP to avoid invalid or duplicate data. <br>Only after passing all validations is a new manager record added to the database.
            </p>

            <h2>3. Access Control for Management Functions</h2>
            <p>
                To protect sensitive data, we have restricted access to the EOI management page (<strong>manage.php</strong>). <br>Only managers who have successfully logged in can view or update EOI records. <br>This is accomplished using PHP sessions: when a manager logs in, a session variable is set, and <strong>manage.php</strong> checks for this session before allowing access. <br>If a user tries to access the page without being logged in, they are redirected to the login page. This enhancement ensures only authorized personnel can manage or view sensitive applicant information.
            </p>

            <h2>4. Login Lockout After Multiple Failed Attempts</h2>
            <p>
                To further enhance security and defend against brute-force attacks, we implemented a lockout mechanism on the manager login page. <br>If a manager enters an incorrect password three times in a row, the login system disables further login attempts for a set period (e.g., five minutes). <br>This is managed using session variables to track failed attempts and the lockout time. When locked out, the manager is shown a clear message explaining the reason and when they can try again. <br>This enhancement prevents attackers from repeatedly guessing passwords and keeps manager accounts secure.
            </p>

            <hr>
            <p style="text-align:center;">
                <a href="index.php" class="btn">Return to Home Page</a>
            </p>
        </section>
    </main>
</body>
</html>
