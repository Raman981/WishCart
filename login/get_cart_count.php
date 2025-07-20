<?php
session_start();
include("connect.php");

$cart_count = 0;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $result = mysqli_query($conn, "SELECT SUM(quantity) AS total FROM cart WHERE Users_ID = $user_id");
    $row = mysqli_fetch_assoc($result);
    $cart_count = $row['total'] ?? 0;
}

echo $cart_count;
?>
