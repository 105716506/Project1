<head> <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keywords" content="QuantumTech, Technology, Future, Website, Cloud, Engineer, FrontEnd, Developer, Data, Analyst, Jobs, Apply, Salary, Careers" />
  <meta name="description" content="Welcome to QuantumTech - Innovating the Future">
  <title>QuantumTech | Register</title> <!-- title of the website-->
  <link href="Styles/Styles.css" rel="stylesheet"> <!-- References to external CSS files -->
</head>

<?php
// Manager Registration Page
session_start();
include_once('settings.php'); // DB connection vars
include 'header.inc'; 

// Feedback messages
$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    // Password rule: at least 8 chars, 1 letter, 1 number
    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
        $errors[] = "Password must be at least 8 characters long and include both letters and numbers.";
    }
    if ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    // Check username not empty and not too long
    if ($username === "" || strlen($username) > 30) {
        $errors[] = "Username is required and must be less than 31 characters.";
    }

    // Proceed if no errors so far
    if (empty($errors)) {
        $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
        if (!$conn) die("Database connection failed.");

        // Create table if not exists
        $sql_create = "CREATE TABLE IF NOT EXISTS managers (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(30) UNIQUE NOT NULL,
            password_hash VARCHAR(255) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        mysqli_query($conn, $sql_create);

        // Check unique username
        $stmt = $conn->prepare("SELECT * FROM managers WHERE username=?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $errors[] = "Username already exists. Please choose another.";
        } else {
            // Insert new manager
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO managers (username, password_hash) VALUES (?, ?)");
            $stmt->bind_param('ss', $username, $hash);
            if ($stmt->execute()) {
                $success = "Registration successful! You may now <a href='login.php'>log in</a>.";
            } else {
                $errors[] = "Registration failed. Please try again.";
            }
        }
        $stmt->close();
        $conn->close();
    }
}
?>

<main>
    <h1>Manager Registration</h1>
    <?php foreach ($errors as $e) echo "<p style='color:red;'>$e</p>"; ?>
    <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>
    <form class="manager-form" method="post" action="register_manager.php" autocomplete="off">
        <label>Username:
            <input type="text" name="username" maxlength="30" required>
        </label><br><br>
        <label>Password:
            <input type="password" name="password" required>
        </label><br><br>
        <label>Confirm Password:
            <input type="password" name="confirm_password" required>
        </label><br><br>
        <input type="submit" value="Register">
    </form>
</main>

<?php include 'footer.inc'; ?>
