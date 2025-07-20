<?php
session_start();
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Use correct name from your form input
    $product_id = $_POST['product_ID']; // ✅ Make sure it matches the form exactly
    $quantity = $_POST['quantity'];

    // Validation (optional)
    if ($quantity < 1) {
        $quantity = 1;
    }

    // Update the cart
    $update_query = "UPDATE cart SET quantity = $quantity WHERE product_ID = $product_id";
    $result = mysqli_query($conn, $update_query);

    if ($result) {
        header("Location: cart.php");
        exit;
    } else {
        echo "Error updating cart: " . mysqli_error($conn);
    }
}

?>
