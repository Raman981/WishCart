
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include("connect.php");

$user_id = $_SESSION['user_id'] ?? 0;
$row_count = 0;

if ($user_id) {
    // Count cart items for navbar display
    $count_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE Users_ID = $user_id") or die('Query failed');
    $row_count = mysqli_num_rows($count_query);

    // Handle add to cart
    if (isset($_POST['add_to_cart'])) {
        $product_id = intval($_POST['product_id']);
        $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
        $price = floatval($_POST['price']);
        $quantity = intval($_POST['quantity']);

        if ($product_id && $product_name && $price > 0 && $quantity > 0) {
            // Check if product already exists
            $check_query = mysqli_query($conn, "SELECT * FROM cart WHERE Users_ID = $user_id AND product_ID = $product_id");

            if (mysqli_num_rows($check_query) > 0) {
                echo "⚠️ Product already added to the cart!";
            } else {
                // Insert product into cart
                $insert = mysqli_query($conn, "INSERT INTO cart (Users_ID, product_ID, product_name, price, quantity) 
                                               VALUES ($user_id, $product_id, '$product_name', $price, $quantity)");

                if ($insert) {
                    echo "✅ Product added to cart successfully!";
                } else {
                    echo "❌ Error inserting item: " . mysqli_error($conn);
                }
            }
        } else {
            echo "⚠️ Invalid product data!";
        }
    }
} else {
    echo "🔒 Please login first.";
}
?><!doctype html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width , initial-scale=1.0">
      <title> Khusi ke pal</title>
	<link rel="stylesheet" href="css/style.css">

    
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
                              <li><a class="active" href="Electronics.php">Electronics</a></li>
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
				<a href="cart.html"><i class="fa-solid fa-cart-shopping"></i></a>
				<li id="lg-bag"><a href="profile.php" class="profile-icon"><i class="fas fa-user"></i></a></li>
				<i id="bar" class="fas fa-outdent"></i>
			</div>
			
      </section>
	    
	    
	  
	    <section id="product" class="section-p2">
	        <h2>Top Electronics: Phones, Laptops, Accessories & More</h2>
		    <p>From Smartphones to Smart Homes — We’ve Got It All!</p>
		    <div class="pro-container">
		    <div class="pro">
			    <a href="newproduct/newp1.php"><img src="../images/Electronic 1.jpg" alt="">
				<div class="des">
				    <span>Apple</span>
					<h5>Apple Watch Series 9[GPS + Cellular 41mm]</h5>
					<div class="star">
					<i class="fas fa-star"></i>
		                  <i class="fas fa-star"></i>
		                  <i class="fas fa-star"></i>
					</div>
					<h4>$15</h4>
				</div>
				<div class="cart">
				<a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
				</div>
            </div>
			
			 <div class="pro">
			    <img src="../images/Electronic 2.jpg" alt="">
				<div class="des">
				    <span>LG</span>
					<h5>LG 27MS550 (27 inch) IPS Full HD(1920 x 1080)</h5>
					<div class="star">
		                        <i class="fas fa-star"></i>
		                        <i class="fas fa-star"></i>
					</div>
					<h4>$22</h4>
				</div>
				<div class="cart">
				<a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
				</div>
            </div>
			
			 <div class="pro">
			    <img src="../images/Electronic 3.jpg" alt="">
				<div class="des">
				    <span>pTRON</span>
					<h5>pTRON Newly Launched Fusion Tunes</h5>
					<div class="star">
		                  <i class="fas fa-star"></i>
		                  <i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					</div>
					<h4>$29</h4>
				</div>
				<div class="cart">
				<a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
				</div>
            </div>
			
			 <div class="pro">
			    <img src="../images/Electronic 4.jpg" alt="">
				<div class="des">
				    <span>Canon</span>
					<h5>canon EOS R10 24.2MP MirrorLess Camera</h5>
					<div class="star">
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
						<i class="fas fa-star"></i>
		                  </div>
					<h4>$26</h4>
				</div>
				<div class="cart">
				<a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
				</div>
            </div>
			
			 <div class="pro">
			    <img src="../images/Electronic 5.jpg" alt="">
				<div class="des">
				    <span>Samsung</span>
					<h5>Samsung Galaxy S24 Ultra 5G AI Smartphone</h5>
					<div class="star">
					<i class="fas fa-star"></i>
		            <i class="fas fa-star"></i>
		            <i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
		            <i class="fas fa-star"></i>
					</div>
					<h4>$70</h4>
				</div>
				<div class="cart">
				<a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
				</div>
            </div>
			
			<div class="pro">
			    <img src="../images/Electronic 6.jpg" alt="">
				<div class="des">
				    <span>ASUS </span>
					<h5>ASUS TUF Gaming A15, Ryzen 7 7435HS </h5>
					<div class="star">
					     <i class="fas fa-star"></i>
		                       <i class="fas fa-star"></i>
					     <i class="fas fa-star"></i>
		                       <i class="fas fa-star"></i>
		                       <i class="fas fa-star"></i>
					</div>
					<h4>$39</h4>
				</div>
				<div class="cart">
				<a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
				</div>
            </div>
			
			<div class="pro">
			    <img src="../images/Electronic 7.jpg" alt="">
				<div class="des">
				    <span>Dyazo</span>
					<h5>Dyazo 6 Angles portable Tabletop Laptop</h5>
					<div class="star">
					<i class="fas fa-star"></i>
		                  <i class="fas fa-star"></i>
				      <i class="fas fa-star"></i>
		                  <i class="fas fa-star"></i>
					</div>
					<h4>$34</h4>
				</div>
				<div class="cart">
				<a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
				</div>
            </div>
			
			<div class="pro">
			    <img src="../images/Electronic 8.jpg" alt="">
				<div class="des">
				    <span>SWAPITECH </span>
					<h5>Swapitech gaming Mouse</h5>
					<div class="star">
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					</div>
					<h4>$43</h4>
				</div>
				    <div class="cart">
				    <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
				</div>
                  </div>
			<div class="pro">
			    <img src="../images/Electronic 9.jpg" alt="">
				<div class="des">
				    <span>boAt</span>
					<h5>boAt Rockerz 255 pro + </h5>
					<div class="star">
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
		                  <i class="fas fa-star"></i>
		                  <i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					</div>
					<h4>$23</h4>
				</div>
				    <div class="cart">
				    <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
				</div>
                  </div>
			<div class="pro">
			    <img src="../images/Electronic 10.jpg" alt="">
				<div class="des">
				    <span>Mivi</span>
					<h5>Mivi Commando X7 [Just Launched] Gaming in Ear</h5>
					<div class="star">
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					</div>
					<h4>$23</h4>
				</div>
				    <div class="cart">
				    <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
				</div>
                  </div>
			<div class="pro">
			    <img src="../images/Electronic 11.jpg" alt="">
				<div class="des">
				    <span>Mivi</span>
					<h5>Mivi SuperPods Halo</h5>
					<div class="star">
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
		                  <i class="fas fa-star"></i>
		                  <i class="fas fa-star"></i>
				      <i class="fas fa-star"></i>
					</div>
					<h4>$23</h4>
				</div>
				    <div class="cart">
				    <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
				</div>
                  </div>
			<div class="pro">
			    <img src="../images/Electronic 12.jpg" alt="">
				<div class="des">
				    <span>pTRON</span>
					<h5>pTRON Fusion Quad V2 40W Bluetooth</h5>
					<div class="star">
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
		                  <i class="fas fa-star"></i>
		                  <i class="fas fa-star"></i>
					</div>
					<h4>$23</h4>
				</div>
				    <div class="cart">
				    <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
				</div>
                  </div>
		    </div>
		</section>
		
		
		
		
		<section id="newletter"  class="section-p1 section-m1">
		    <div class="newstext">
			    <h4> Sign Up For Newsletter </h4>
				<p> Get E-Mail Updates about our latest shop <span> Special offer </span> 
				</p>
		    </div>
			<div class="form">
			    <input type="text" placeholder="Your Email address"/>
				<button> Sign Up</button>
			</div>
		</section>
		
		<footer class="section-p1">
		    <div class="col">
			    <img src="../images/wishcart.png" class="logo" alt="">
				<h4> Contact </h4>
				<p><strong>Address</strong> Amity University Kolkata<br> 
				    Major Arterial Road, <br> 
				    Action Area II, Rajarhat,<br> 
                    New Town,Kolkata - 700135,<br> 
                    West Bengal, India </p>
				<p> <strong> Phone:</strong>+91 1234 567 890 /(+91) 01 2345 987</p>
				<p> <strong>Hours: </strong> 10:00 - 18:00, Mon - Sat</p>	
				<div class="Follow">
				    <h4> Follow Us</h4>
					<div class="icon">
					    <i class="fa-brands fa-square-facebook"></i>
                        <i class="fa-brands fa-square-twitter"></i>	
                        <i class="fa-brands fa-square-instagram"></i>	
						<i class="fa-brands fa-square-pinterest"></i>
						<i class="fa-brands fa-youtube"></i>
					</div>
				</div>	
			</div> 
			
			<div class="col">
			    <h4> About</h4>
				<a href="#"> About us</a>
				<a href="#"> Delivery Inforamtion </a>
				<a href="#"> Privacy Policy </a>
				<a href="#">Terms & Conditions </a>
				<a href="#">Contact Us</a>
			</div>
			
			<div class="col">
			    <h4> My Account</h4>
				<a href="#"> Sign In</a>
				<a href="#"> View Cart </a>
				<a href="#"> My Wishlist </a>
				<a href="#">Track My Order </a>
				<a href="#">Help</a>
			</div>
			
			
		    <div class="col">
			    <h4> Install App</h4>
				<p>From App Store or Google play</p>
				<div class="row">
				    <img src="../images/play store 4.jpg" class="store" alt="">
				</div> 	
				<p> Secured Payment Gateways</p>
				 <img src="../images/payment.jpg" class="payment" alt="">
			</div>
			
			<div class="copywrite">
			<p>@ 2024, Raman etc HTML /CSS E-commerce Website</p>
			</div>
		</footer>  
		
		
		<script src="../script/script.js"></script> 
		
		
</body>
</html>