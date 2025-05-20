<?php
require_once("settings.php");

// Redirect if accessed without POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: apply.php');
    exit();
}

// Connect to DB
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Sanitize input helper
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Validation helpers
function validate_alpha($str, $maxLength) {
    return preg_match("/^[a-zA-Z]{1,$maxLength}$/", $str);
}

function validate_postcode($postcode, $state) {
    // Define state to postcode pattern
    $patterns = [
        'VIC' => '/^3|8\d{3}$/',
        'NSW' => '/^1|2\d{3}$/',
        'QLD' => '/^4|9\d{3}$/',
        'NT' => '/^0\d{3}$/',
        'WA' => '/^6\d{3}$/',
        'SA' => '/^5\d{3}$/',
        'TAS' => '/^7\d{3}$/',
        'ACT' => '/^0\d{3}$/'
    ];
    if (!isset($patterns[$state])) return false;
    return preg_match("/^" . $patterns[$state] . "$/", $postcode);
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_phone($phone) {
    return preg_match("/^[0-9 ]{8,12}$/", $phone);
}

// Collect and sanitize inputs
$jobRef = clean_input($_POST['jobRef'] ?? '');
$firstName = clean_input($_POST['firstName'] ?? '');
$lastName = clean_input($_POST['lastName'] ?? '');
$dob = clean_input($_POST['dob'] ?? '');
$gender = clean_input($_POST['gender'] ?? '');
$street = clean_input($_POST['street'] ?? '');
$suburb = clean_input($_POST['suburb'] ?? '');
$state = clean_input($_POST['state'] ?? '');
$postcode = clean_input($_POST['postcode'] ?? '');
$email = clean_input($_POST['email'] ?? '');
$phone = clean_input($_POST['phone'] ?? '');
$skills = isset($_POST['skills']) ? $_POST['skills'] : [];
$otherSkills = clean_input($_POST['otherSkills'] ?? '');

// Validation flags and messages
$errors = [];

// Validate jobRef (non-empty)
if (empty($jobRef)) {
    $errors[] = "Job reference number is required.";
}

// Validate names (max 20 alpha chars)
if (!validate_alpha($firstName, 20)) {
    $errors[] = "First name must be max 20 alphabetic characters.";
}
if (!validate_alpha($lastName, 20)) {
    $errors[] = "Last name must be max 20 alphabetic characters.";
}

// Validate DOB (dd/mm/yyyy)
if (!preg_match("/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[012])\/\d{4}$/", $dob)) {
    $errors[] = "Date of birth must be in dd/mm/yyyy format.";
}

// Validate gender
if (!in_array($gender, ['Male', 'Female', 'Other'])) {
    $errors[] = "Gender must be selected.";
}

// Validate street and suburb max 40 chars
if (strlen($street) > 40 || empty($street)) {
    $errors[] = "Street address is required and must be max 40 characters.";
}
if (strlen($suburb) > 40 || empty($suburb)) {
    $errors[] = "Suburb/Town is required and must be max 40 characters.";
}

// Validate state
$validStates = ['VIC', 'NSW', 'QLD', 'NT', 'WA', 'SA', 'TAS', 'ACT'];
if (!in_array($state, $validStates)) {
    $errors[] = "State is invalid.";
}

// Validate postcode exactly 4 digits and matches state
if (!preg_match("/^\d{4}$/", $postcode) || !validate_postcode($postcode, $state)) {
    $errors[] = "Postcode must be exactly 4 digits and match the state.";
}

// Validate email format
if (!validate_email($email)) {
    $errors[] = "Email address is invalid.";
}

// Validate phone (8-12 digits or spaces)
if (!validate_phone($phone)) {
    $errors[] = "Phone number must be 8 to 12 digits or spaces.";
}

// Validate skills (at least one selected)
if (empty($skills) || !is_array($skills)) {
    $errors[] = "At least one technical skill must be selected.";
}

// If 'Other skills' checkbox is selected, otherSkills should not be empty
if (in_array('Other', $skills) && empty($otherSkills)) {
    $errors[] = "Please describe your other skills.";
}

// Show errors if any
if (!empty($errors)) {
    echo "<h2>Validation errors occurred:</h2><ul>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul><p><a href='apply.php'>Go back to application form</a></p>";
    exit();
}

// Prepare skills for storage (assuming skill1, skill2, skill3, skill4 for example)
$skill1 = in_array('Skill1', $skills) ? 1 : 0;
$skill2 = in_array('Skill2', $skills) ? 1 : 0;
$skill3 = in_array('Skill3', $skills) ? 1 : 0;
$skill4 = in_array('Other', $skills) ? 1 : 0;

// Insert into eoi table
$sql = "INSERT INTO eoi 
(jobRef, firstName, lastName, dob, gender, street, suburb, state, postcode, email, phone, skill1, skill2, skill3, skill4, otherSkills, status) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'New')";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param(
    "sssssssssssiiiis",
    $jobRef,
    $firstName,
    $lastName,
    $dob,
    $gender,
    $street,
    $suburb,
    $state,
    $postcode,
    $email,
    $phone,
    $skill1,
    $skill2,
    $skill3,
    $skill4,
    $otherSkills
);

if ($stmt->execute()) {
    $eoiNumber = $stmt->insert_id;
    echo "<h2>Thank you for your application.</h2>";
    echo "<p>Your Expression of Interest number is: <strong>" . htmlspecialchars($eoiNumber) . "</strong></p>";
    echo "<p><a href='index.php'>Return to Home Page</a></p>";
} else {
    echo "<p>There was an error processing your application. Please try again.</p>";
}

$stmt->close();
$conn->close();
?>
