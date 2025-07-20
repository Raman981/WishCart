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






$user_id = $_SESSION['user_id'] ?? 0;
$row_count = 0;

if ($user_id) {
    // Count cart items for navbar display
    $count_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE Users_ID = $user_id") or die('Query failed');
    $row_count = mysqli_num_rows($count_query);
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

      <section id="main-content">
            <div class="left-column">
                  <div class="profile_container">
                         <img src="../images/profile-icon.png" class="profile-picture" alt="Profile Picture">

                        <div class="profile-text">
                            <p class="greeting">Hello,</p>
                            <p class="username"><?php echo htmlspecialchars($name); ?></p>
                        </div>
                  </div>

        <aside id="sidebar">
           <ul>
                <li><a class="active" href="#" onclick="showSection('profile')"><i class="fas fa-user"></i> Profile Information</a></li>
                <li><a href="#" onclick="showSection('orders')"><i class="fas fa-box"></i> My Order</a></li>
                <li><a href="#" onclick="showSection('addresses')"><i class="fas fa-map-marker-alt"></i> Manage Addresses</a></li>
                <li><a href="#" onclick="showSection('notifications')"><i class="fas fa-bell"></i> Notifications</a></li>
                <li><a href="#" onclick="showSection('payment')"><i class="fas fa-credit-card"></i> Payment </a></li>
                <li><a href="#"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
           </ul>

        </aside>
    </div>
    <div class="content">
      <div id="profile" class="section">
          <div class="profile-header">
            <div class="pro-head">
              <h2>Profile Information</h2>
              <button id="edit-btn" class="edit-button" onclick="toggleEdit()">Edit</button>
            </div>
          </div>

          <form action="save_profile.php" method="post" autocomplete="off">
  <div class="name-box">
    <div class="first-name">
      <label for="first-name">Enter your name</label><br>
      <input type="text" id="first-name" name="first_name" placeholder="First Name" required><br><br>
    </div>

    <div class="second-name">
      <input type="text" id="second-name" name="second_name" placeholder="Second Name" required>
    </div>
  </div>

  <div class="gender">
    <p>Your Gender</p>
    <div class="male-female">
      <input type="radio" id="male"   name="gender" value="Male"   required>
      <label for="male">Male</label><br>
      <input type="radio" id="female" name="gender" value="Female">
      <label for="female">Female</label><br><br>
    </div>
  </div>

  <div class="email">
    <label for="mail">Enter your Mail</label><br>
    <input type="email" id="mail" name="email" placeholder="Email Here" required><br><br>
  </div>

  <div class="ph-number">
    <label for="phone">Mobile Number</label><br>
   <input type="tel" id="phone" name="phone_number"
       placeholder="Enter your phone number"
       maxlength="10"
       pattern="\d{10}"
       title="Phone number must be exactly 10 digits"
       required>

  </div>

             <button id="save-btn" class="save-button" onclick="saveChanges()">Save</button>

            <div class="FAQ">
              <h2> FAQs</h2>
              <div class="ques-ans">
                <h5>What happens when I update my email address (or mobile number)?</h5>
                <p>Your login email id (or mobile number) changes, likewise. You'll receive all 
                  your account related communication on your updated email address (or mobile number).</p>

                  <h5>When will my WishCart account be updated with the new email address (or mobile number)?</h5>
                  <p>It happens as soon as you confirm the verification code sent to your email (or mobile) and save the changes.</p>

                  <h5>What happens to my existing WishCart account when I update my email address (or mobile number)?</h5>
                  <p>Updating your email address (or mobile number) doesn't invalidate your account. Your account remains fully functional.
                     You'll continue seeing your Order history, saved information and personal details.</p>
                </div>

            </div>

            <div class="deactivate-account">
              <button id="Deactivate-btn" class="deactivate-button" >Deactivate Account</button>
            </div>

            <div class="Delete-Account">
              <button id="Delete-btn" class="delete-button">Delete Account</button>
            </div>
    </div>

    <div id="orders" class="section">
      <h2>My Orders</h2>
      <p>Here is your order history...</p>
    </div>

    
    <div id="addresses" class="section">
      <h2>Manage Addresses</h2>
      <p>Here you can manage your delivery addresses.</p>
    </div>

    <div id="notifications" class="section">
      <h2>Notifications</h2>
      <p>Your notification settings and alerts will appear here.</p>
    </div>

    <div id="payment" class="section">
      <h2>Payment</h2>
      <p>Manage your saved cards and payment methods.</p>
    </div>
  </div>
</section>



    
    <script >
  function showSection(sectionId) {
    // Hide all sections
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => section.classList.remove('active'));

    // Show the selected section
    const selected = document.getElementById(sectionId);
    if (selected) {
      selected.classList.add('active');
      // Save the selected section to localStorage
      localStorage.setItem('activeSection', sectionId);
    }
  }

  // Run this on page load to restore last section
  document.addEventListener('DOMContentLoaded', () => {
    const savedSection = localStorage.getItem('activeSection') || 'orders'; // default to orders
    showSection(savedSection);
  });

  // Save original values
  let originalData = {};

  window.onload = function () {
    // Store original values
    originalData.firstName = document.getElementById("first-name").value;
    originalData.secondName = document.getElementById("second-name").value;
    originalData.email = document.getElementById("mail").value;
    originalData.phone = document.getElementById("phone").value;
    originalData.gender = document.querySelector('input[name="gender"]:checked')?.value || '';

    // Lock all fields
    lockFields();

    // Handle tab restore
    const savedSection = localStorage.getItem('activeSection') || 'orders';
    showSection(savedSection);
  };

  function lockFields() {
    document.getElementById("first-name").setAttribute("readonly", true);
    document.getElementById("second-name").setAttribute("readonly", true);
    document.getElementById("mail").setAttribute("readonly", true);
    document.getElementById("phone").setAttribute("readonly", true);
    document.querySelectorAll('input[name="gender"]').forEach(r => r.setAttribute("disabled", true));

    document.getElementById("save-btn").style.display = "none";
    document.getElementById("edit-btn").innerText = "Edit";
  }

  function unlockFields() {
    document.getElementById("first-name").removeAttribute("readonly");
    document.getElementById("second-name").removeAttribute("readonly");
    document.getElementById("mail").removeAttribute("readonly");
    document.getElementById("phone").removeAttribute("readonly");
    document.querySelectorAll('input[name="gender"]').forEach(r => r.removeAttribute("disabled"));

    document.getElementById("save-btn").style.display = "inline-block";
    document.getElementById("edit-btn").innerText = "Cancel";
  }

  function toggleEdit() {
    const editBtn = document.getElementById("edit-btn");
    if (editBtn.innerText === "Edit") {
      unlockFields();
    } else {
      // Reset values
      document.getElementById("first-name").value = originalData.firstName;
      document.getElementById("second-name").value = originalData.secondName;
      document.getElementById("mail").value = originalData.email;
      document.getElementById("phone").value = originalData.phone;

      // Reset gender
      if (originalData.gender) {
        document.querySelectorAll('input[name="gender"]').forEach(r => {
          r.checked = (r.value === originalData.gender);
        });
      }

      lockFields();
    }
  }

  function saveChanges() {
    // Update original values
    originalData.firstName = document.getElementById("first-name").value;
    originalData.secondName = document.getElementById("second-name").value;
    originalData.email = document.getElementById("mail").value;
    originalData.phone = document.getElementById("phone").value;
    originalData.gender = document.querySelector('input[name="gender"]:checked')?.value || '';
  document.querySelectorAll('input[name="gender"]').forEach(r => r.removeAttribute('disabled'));
  // form submits normally…


    lockFields();

    // Optional: Show alert or toast
    // alert("Profile updated successfully!");
  }

  // Tab switching function
  function showSection(sectionId) {
    document.querySelectorAll('.section').forEach(section => section.classList.remove('active'));
    const selected = document.getElementById(sectionId);
    if (selected) {
      selected.classList.add('active');
      localStorage.setItem('activeSection', sectionId);
    }
  }


    </script>
</body>

</html>
