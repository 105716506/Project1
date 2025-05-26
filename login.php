<?php
// Manager Login Page
session_start();
include_once('settings.php'); // DB connection vars
include 'header.inc';
include 'nav.inc';

// Lockout settings
$lockout_time = 5 * 60; // 5 minutes (in seconds)
if (!isset($_SESSION['login_attempts'])) $_SESSION['login_attempts'] = 0;
if (!isset($_SESSION['lockout_time'])) $_SESSION['lockout_time'] = 0;

$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['login_attempts'] < 3) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
    if (!$conn) die("Database connection failed.");

    // Create table if not exists (in case registration not yet done)
    $sql_create = "CREATE TABLE IF NOT EXISTS managers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) UNIQUE NOT NULL,
        password_hash VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )";
    mysqli_query($conn, $sql_create);

    // Authenticate
    $stmt = $conn->prepare("SELECT * FROM managers WHERE username=?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 1) {
        $row = $res->fetch_assoc();
        if (password_verify($password, $row['password_hash'])) {
            // Success: reset attempts, set login session
            $_SESSION['manager_logged_in'] = true;
            $_SESSION['manager_username'] = $username;
            $_SESSION['login_attempts'] = 0;
            $_SESSION['lockout_time'] = 0;
            header("Location: manage.php");
            exit;
        }
    }

    // If here, login failed
    $_SESSION['login_attempts'] += 1;
    if ($_SESSION['login_attempts'] >= 3) {
        $_SESSION['lockout_time'] = time();
    }
    $errors[] = "Invalid username or password.";
}

// If locked out, check if lockout period expired
$locked_out = false;
if ($_SESSION['login_attempts'] >= 3) {
    $elapsed = time() - $_SESSION['lockout_time'];
    if ($elapsed < $lockout_time) {
        $locked_out = true;
        $remaining = $lockout_time - $elapsed;
    } else {
        // Reset after lockout expires
        $_SESSION['login_attempts'] = 0;
        $_SESSION['lockout_time'] = 0;
        $locked_out = false;
    }
}
?>

<main>
    <h1>Manager Login</h1>
    <?php foreach ($errors as $e) echo "<p style='color:red;'>$e</p>"; ?>
    <?php if ($locked_out): ?>
        <p style="color:red;">
            Too many failed login attempts. Please wait <?php echo ceil($remaining / 60); ?> minutes before trying again.
        </p>
    <?php else: ?>
        <form class="manager-form" method="post" action="login.php" autocomplete="off">
            <label>Username:
                <input type="text" name="username" maxlength="30" required>
            </label><br><br>
            <label>Password:
                <input type="password" name="password" required>
            </label><br><br>
            <input type="submit" value="Login">
        </form>
        <p>Not registered? <a href="register_manager.php">Register here</a></p>
    <?php endif; ?>
</main>

<?php include 'footer.inc'; ?>
