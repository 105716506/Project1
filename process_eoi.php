<?php
require_once("settings.php");

// Redirect if not POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: apply.php');
    exit();
}

// Connect to DB
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) die("Database connection failed: " . mysqli_connect_error());

// Sanitize helper
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// --- Collect & Clean Inputs ---
$jobRef    = clean_input($_POST['jobRef'] ?? '');
$firstName = clean_input($_POST['firstName'] ?? '');
$lastName  = clean_input($_POST['lastName'] ?? '');
$dob       = clean_input($_POST['dob'] ?? '');
$gender    = clean_input($_POST['gender'] ?? '');
$street    = clean_input($_POST['street'] ?? '');
$suburb    = clean_input($_POST['suburb'] ?? '');
$state     = clean_input($_POST['state'] ?? '');
$postcode  = clean_input($_POST['postcode'] ?? '');
$email     = clean_input($_POST['email'] ?? '');
$phone     = clean_input($_POST['phone'] ?? '');
$skills    = isset($_POST['skills']) ? $_POST['skills'] : [];
$otherSkills = clean_input($_POST['otherSkills'] ?? '');

$errors = [];

// --- VALIDATION ---

// Helper: alpha only, max len
function validate_alpha($str, $maxLength) {
    return preg_match("/^[a-zA-Z]{1,$maxLength}$/", $str);
}
// Helper: valid email
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
// Helper: phone (digits & spaces, 8-12)
function validate_phone($phone) {
    return preg_match("/^[0-9 ]{8,12}$/", $phone);
}

// Postcode validation by state (HD-level)
function valid_postcode($postcode, $state) {
    $ranges = [
        'VIC' => [ [3000, 3999], [8000, 8999] ],
        'NSW' => [ [1000, 1999], [2000, 2599], [2619, 2898], [2921, 2999] ],
        'QLD' => [ [4000, 4999], [9000, 9999] ],
        'NT'  => [ [800, 899], [900, 999] ],
        'WA'  => [ [6000, 6797], [6800, 6999] ],
        'SA'  => [ [5000, 5799], [5800, 5999] ],
        'TAS' => [ [7000, 7799], [7800, 7999] ],
        'ACT' => [ [200, 299], [2600, 2618], [2900, 2920] ]
    ];
    if (!isset($ranges[$state])) return false;
    foreach ($ranges[$state] as $range) {
        if ($postcode >= $range[0] && $postcode <= $range[1]) return true;
    }
    return false;
}

// Job Reference
if (empty($jobRef)) $errors[] = "Job reference number is required.";

// Names (max 20 alpha)
if (!validate_alpha($firstName, 20)) $errors[] = "First name must be max 20 letters.";
if (!validate_alpha($lastName, 20))  $errors[] = "Last name must be max 20 letters.";

// DOB format
if (!preg_match("/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[012])\/\d{4}$/", $dob)) {
    $errors[] = "Date of birth must be in dd/mm/yyyy format.";
}

// Gender
if (!in_array($gender, ['Male', 'Female', 'Other'])) $errors[] = "Gender must be selected.";

// Address
if (empty($street) || strlen($street) > 40) $errors[] = "Street is required and max 40 characters.";
if (empty($suburb) || strlen($suburb) > 40) $errors[] = "Suburb/Town is required and max 40 characters.";

// State
$validStates = ['VIC', 'NSW', 'QLD', 'NT', 'WA', 'SA', 'TAS', 'ACT'];
if (!in_array($state, $validStates)) $errors[] = "State is invalid.";

// Postcode: 4 digits and valid for state
if (!preg_match('/^\d{4}$/', $postcode) || !valid_postcode((int)$postcode, $state)) {
    $state_names = [
        'VIC' => 'Victoria', 'NSW' => 'New South Wales', 'QLD' => 'Queensland', 'NT' => 'Northern Territory',
        'WA' => 'Western Australia', 'SA' => 'South Australia', 'TAS' => 'Tasmania', 'ACT' => 'Australian Capital Territory'
    ];
    $errors[] = "Postcode must be 4 digits and valid for {$state_names[$state]}.";
}

// Email & phone
if (!validate_email($email))   $errors[] = "Email address is invalid.";
if (!validate_phone($phone))   $errors[] = "Phone number must be 8 to 12 digits or spaces.";

// Skills
if (empty($skills) || !is_array($skills)) $errors[] = "At least one skill must be selected.";

// Other skills if checked
if (in_array('Other', $skills) && empty($otherSkills)) {
    $errors[] = "Please describe your other skills.";
}

// --- ERROR DISPLAY ---

if (!empty($errors)) {
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Submission Error | QuantumTech</title>
        <link href="Styles/Styles.css" rel="stylesheet">
    </head>
    <body>
        <main>
            <div class="error-message">
                <h2>Submission Error</h2>
                <ul>';
                foreach ($errors as $error) echo "<li>" . htmlspecialchars($error) . "</li>";
    echo    '</ul>
                <p style="text-align:center;"><a href="apply.php" class="btn">Back to Form</a></p>
            </div>
        </main>
    </body>
    </html>';
    exit();
}

// --- Insert Application (prepared statement) ---

$skill1 = in_array('Skill1', $skills) ? 1 : 0;
$skill2 = in_array('Skill2', $skills) ? 1 : 0;
$skill3 = in_array('Skill3', $skills) ? 1 : 0;
$skill4 = in_array('Other',  $skills) ? 1 : 0;

$sql = "INSERT INTO eoi 
(jobRef, firstName, lastName, dob, gender, street, suburb, state, postcode, email, phone, skill1, skill2, skill3, skill4, otherSkills, status) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'New')";

$stmt = $conn->prepare($sql);
if (!$stmt) die("Prepare failed: " . $conn->error);

$stmt->bind_param(
    "sssssssssssiiiis",
    $jobRef, $firstName, $lastName, $dob, $gender, $street, $suburb, $state,
    $postcode, $email, $phone, $skill1, $skill2, $skill3, $skill4, $otherSkills
);

if ($stmt->execute()) {
    $eoiNumber = $stmt->insert_id;
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Application Received | QuantumTech</title>
        <link href="Styles/Styles.css" rel="stylesheet">
    </head>
    <body>
        <main>
            <div class="success-message">
                <h2>Thank you for your application.</h2>
                <p>Your Expression of Interest number is: <strong>' . htmlspecialchars($eoiNumber) . '</strong></p>
                <p><a href="index.php" class="btn">Return to Home Page</a></p>
            </div>
        </main>
    </body>
    </html>';
} else {
    echo '<div class="error-message"><p>There was an error processing your application. Please try again.</p></div>';
}

$stmt->close();
$conn->close();
?>
