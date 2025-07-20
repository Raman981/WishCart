<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include("connect.php");

if (!isset($_SESSION['user_id'])) {
    echo "Login required";
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = intval($_POST['product_id']);
$product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
$price = floatval($_POST['price']);
$quantity = intval($_POST['quantity']);

// 🔁 Check if product already exists in cart for this user
$check_sql = "SELECT * FROM cart WHERE Users_ID = $user_id AND product_ID = $product_id";
$check_result = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($check_result) > 0) {
    echo " Product already added to the cart!";  // 🟥 Already in cart
} else {
    // ✅ Insert into cart
    $insert_sql = "INSERT INTO cart (Users_ID, product_ID, product_name, price, quantity) 
                   VALUES ($user_id, $product_id, '$product_name', $price, $quantity)";
    if (mysqli_query($conn, $insert_sql)) {
        echo " Product added to the cart!";  // ✅ Added
    } else {
        echo "error";
    }
}
?>
