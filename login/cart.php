<?php
session_start();

// ✅ Show all errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("connect.php");

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("SESSION user_id is not set. Please log in first."); // helpful debug message
    // header("Location: login.php"); // Uncomment when you're done testing
    // exit();
}

$user_id = $_SESSION['user_id'];

// ✅ Get cart items using JOIN
$sql = "
    SELECT c.quantity, p.product_id, p.name AS product_name, p.price, p.image
    FROM cart c
    JOIN product p ON c.product_id = p.product_id
    WHERE c.Users_ID = $user_id
";

$result = mysqli_query($conn, $sql);

// ✅ Show error if query fails
if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
}

//update_query
if (isset($_POST['update_product_quantity'])) {
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['product_id'];

    echo "Updated Quantity: " . $update_value . "<br>";
    echo "Product ID: " . $update_id . "<br>";

    // ✅ Now actually update the quantity in the cart table
    $update_sql = "UPDATE cart SET quantity = $update_value WHERE Users_ID = $user_id AND product_id = $update_id";
    $update_result = mysqli_query($conn, $update_sql);

    if ($update_result) {
        echo "Cart updated successfully!";
        // Optional: reload page to show updated values
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo "Update failed: " . mysqli_error($conn);
    }
}
if(isset($_GET['remove'])){
    $remove_product_id=$_GET['remove'];
    //echo $remove_product_id;
    mysqli_query($conn,"Delete from `cart` where product_id=$remove_product_id");
    header('location:cart.php');
}

$user_id = $_SESSION['user_id'] ?? 0;
$row_count = 0;

if ($user_id) {
    // Count cart items for navbar display
    $count_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE Users_ID = $user_id") or die('Query failed');
    $row_count = mysqli_num_rows($count_query);
}


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WishCart</title>
    <link rel="stylesheet" href="CSS/style.css?v=<?php echo time(); ?>">

    

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <section id="header">
        <a href="Home.php"><img src="../images/wishcart.png" class="logo" alt=""></a>

        <div>
            <ul id="navbar">
                <li><a href="Home.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="New.php">New</a></li>
                <li><a href="Electronics.php">Electronics</a></li>
                <li id="lg-bag" style="position: relative;">
                    <a href="cart.php">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <?php if ($row_count > 0): ?>
                        <span class="row_count"><?php echo $row_count; ?></span>
                        <?php endif; ?>
                    </a>
				</li>
                <li id="lg-bag"><a href="profile.php" class="profile-icon"><i class="fas fa-user"></i></a></li>
                <a href="#" id="close"><i class="fa-solid fa-xmark"></i></a>
            </ul>
        </div>

        <div id="mobile">
            <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
            <li id="lg-bag"><a href="profile.php" class="profile-icon"><i class="fas fa-user"></i></a></li>
            <i id="bar" class="fas fa-outdent"></i>
        </div>
    </section>

    <section id="carthero">
        <div class="scart">
            <h1>Your Shopping Cart</h1>
            <p>Review your items and proceed to checkout when you're ready.</p>
        </div>
    </section>

    <section id="cart-content">
        <div class="container">
        <?php
        $total = 0;

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $product = htmlspecialchars($row['product_name']);
                $quantity = $row['quantity'];
                $price = $row['price'];
                $image = htmlspecialchars($row['image']);
                $subtotal = $price * $quantity;
                $total += $subtotal;

                 // Store data for final summary
                    $summaryItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal
                     ];
                ?>
                <div class="cart-item">
                    <img src="images/<?php echo $image; ?>" alt="<?php echo $product; ?>" width="100">
                    <div>
                        <h3><?php echo $product; ?></h3>
                       <form action="" method="post">
                           <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">

                           <div class="quantity_box">
                                    <input type="number"  min="1" value="<?php echo $row['quantity']; ?>"
                                    name="update_quantity">
                                    <input type="submit" class="update_quantity" value="Update" name="update_product_quantity">
                             </div>
                        </form>

                        <p>Price: ₹<?php echo $price; ?></p>
                        <p>Subtotal: ₹<?php echo $subtotal; ?></p>
                    </div>
                </div>
               <div class="Remove_box">
                    <a href="cart.php?remove=<?php echo $row['product_id']; ?>"
                        onclick="return confirm('Are you sure you want to delete this item?')"
                        class="remove-btn">
                        Remove Product
                    </a>
                </div>
             <hr>

                <?php
            }
            ?>
             <!-- Final Order Summary -->
    <div class="place-order-summary">
        <h2> Order Summary</h2>

        <?php foreach ($summaryItems as $item): ?>
            <div class="order-line">
                <div class="order-product"><?php echo $item['product']; ?></div>
                <div class="order-quantity"><?php echo $item['quantity']; ?></div>
                <div class="order-price">₹<?php echo $item['price']; ?></div>
                 <div class="order-subtotal">₹<?php echo $item['subtotal']; ?></div>
            </div>
        <?php endforeach; ?>


            <div class="cart-total">
               
                <h2>Grand Total: ₹<?php echo $total; ?></h2>
            </div>

            <div class="place_order">
                    <a href="place_order.php" class="order-btn">
                        Place Order
                    </a>
            </div>
            <?php
        } else {
            echo "<h2>Your cart is empty.</h2>";
        }
        ?>
        </div>
    </section>

    <footer>
        <div class="copywrite">
            <p>© 2024, Raman etc HTML/CSS E-commerce Website</p>
        </div>
    </footer>

    <script src="../script/script.js"></script>
</body>

</html>
