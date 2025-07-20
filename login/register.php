<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'connect.php';

if (isset($_POST['signUp'])) {
    $name = trim($_POST['Name']);
    $email = trim($_POST['email']);
    $plainPassword = $_POST['password'];

    // ✅ Hash the password securely
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

    // ✅ Check if email already exists (case-insensitive check)
    $checkEmailQuery = "SELECT * FROM users WHERE LOWER(email) = LOWER('$email')";
    $result = $conn->query($checkEmailQuery);

    if ($result && $result->num_rows > 0) {
        echo "<script>alert('Email Address Already Exists!'); window.location.href='index.php';</script>";
    } else {
        // ✅ Use prepared statements (to prevent SQL injection)
        $stmt = $conn->prepare("INSERT INTO users (Name, Email, Password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! Please login.'); window.location.href='index.php';</script>";
        } else {
            echo "❌ Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>
