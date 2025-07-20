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
    // header("Location: login.php"); 
}

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];

// Fetch name and email from DB
$sql = "SELECT NAME, email FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['NAME'];
    $email = $row['email'];
} else {
    $name = "Guest";
    $email = "Unknown";
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
    <section id="order_header">
        <a href="Home.php"><img src="../images/wishcart.png" class="logo" alt=""></a>

        <div>
            <ul id="order_navbar">
              <li class="profile-dropdown">
                    <a href="#" class="profile-dropdown-toggle">
                     <p><strong><?php echo htmlspecialchars($name); ?> <i class="fas fa-chevron-down"></i></p></strong>
                    </a>
    <div class="profile-dropdown-menu">
        <ul>
            <li><a href="profile.php" class="profile-item"><i class="fas fa-user-circle"></i>My Profile</a></li>
            <li><a href="#" class="profile-item"><i class="fas fa-box"></i> Orders</a></li>
            <li><a href="#" class="profile-item"><i class="fas fa-bell"></i> Notifications</a></li>
            <li><a href="#" class="profile-item"><i class="fas fa-lock"></i> Change Password</a></li>
            <li><a href="#" class="profile-item"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
        </ul>
    </div>
</li>

            </ul>
        </div>

        <div id="mobile">
            <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
            <li id="lg-bag"><a href="profile.php" class="profile-icon"><i class="fas fa-user"></i></a></li>
            <i id="bar" class="fas fa-outdent"></i>
        </div>
    </section>

      <section id="order_container">
            <div class="login_container">
                <h1> Place Your Order</h1>
                   <p><strong> Welcome, <?php echo htmlspecialchars($name); ?> (logged IN)</strong></p>  
                     <p>Email: <?php echo htmlspecialchars($email); ?></p>
            </div>
            <hr>

            <div class="Phone-number">
                <label for="Contact">Mobile:</label>
                <input type="text" id="contact"  placeholder="Contact Number"></input><br>
                <hr>
            </div>
            <div class="address">
                <label for="adress">Address:</label>
                <input type="text"  placeholder="Your address"></input><br>
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
