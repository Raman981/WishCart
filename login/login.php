<?php
session_start();
include 'connect.php';

if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password']; // Plain password from form

    // ✅ Step 1: Fetch user by email only
    $sql = "SELECT * FROM Users WHERE Email = '$email'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['Password'];

        // ✅ Step 2: Use password_verify to check password
        if (password_verify($password, $hashed_password)) {
            // ✅ Login success
            $_SESSION['email'] = $row['Email'];
            $_SESSION['user_id'] = $row['ID'];

            setcookie("test_session", "active", time() + 3600, "/");


            header("Location: home.php");
            exit();
        } else {
            echo "<script>alert('Incorrect Password!'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('User not found!'); window.location.href='index.php';</script>";
    }
}
?>
