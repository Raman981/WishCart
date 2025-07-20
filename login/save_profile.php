<?php
session_start();

// ✅ Show all errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("connect.php"); // gives us $conn (mysqli)

// ✅ Step 1: Check session and get user ID (CORE PART)
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] <= 0) {
    die("You must be logged in to save your profile.");
    echo "<p>User ID from session: {$_SESSION['user_id']}</p>";

}

$user_id = $_SESSION['user_id'];  // ✅ THIS IS THE CORE PART

// ✅ Step 2: Grab and sanitize inputs
$first  = trim($_POST['first_name']  ?? '');
$second = trim($_POST['second_name'] ?? '');
$gender = $_POST['gender']  ?? '';
$email  = trim($_POST['email'] ?? '');
$phone  = trim($_POST['phone_number'] ?? '');

// ✅ Step 3: Server-side validation
$errors = [];

if (!$first)  $errors[] = "First name is required.";
if (!$second) $errors[] = "Second name is required.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";

$phone = preg_replace('/\D/', '', $phone);
if (!preg_match('/^\d{10}$/', $phone)) {
    $errors[] = "Phone must be exactly 10 digits.";
}

if ($errors) {
    foreach ($errors as $e) echo "<p style='color:red;'>$e</p>";
    echo "<p><a href='profile.html'>Go back</a></p>";
    exit;
}

// ✅ Step 4: Insert into DB using prepared statement
$sql = "INSERT INTO user_profile 
        (first_name, second_name, gender, email, phone_number, user_id) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $first, $second, $gender, $email, $phone, $user_id);

if ($stmt->execute()) {
    echo "<p style='color:green;'>Profile saved successfully!</p>";
} else {
    echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
}

$stmt->close();
$conn->close();
?>
