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
?>
<!doctype html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewpoint" content="width=device-width , initial-scale=1.0">
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
                              <li><a class="active"  href="New.php">New</a></li>
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
				<a href="cart.html"><i class="fa-solid fa-cart-shopping"></i></a>
				<li id="lg-bag"><a href="profile.php" class="profile-icon"><i class="fas fa-user"></i></a></li>
				<i id="bar" class="fas fa-outdent"></i>
			</div>
			
      </section>
	    
	    
	  
	    <section id="product" class="section-p2">
	        <h2> Fresh Finds for You</h2>
		    <p> Catch the Trend Before It's Gone </p>
		    <div class="pro-container">
		    <div class="pro">
			    <a href="newproduct/newp1.php"><img src="../images/new1.jpg" alt="">
				<div class="des">
				    <span>The Indian Garage</span>
					<h5>Men's Regular Cotton Shirt</h5>
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
			    <img src="../images/new2.jpg" alt="">
				<div class="des">
				    <span>Serein</span>
					<h5>Serein Women's Crepe</h5>
					<div class="star">
		                        <i class="fas fa-star"></i>
		                        <i class="fas fa-star"></i>
					</div>
					<h4>$12</h4>
				</div>
				<div class="cart">
				<a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
				</div>
                  </div>
			
			 <div class="pro">
			    <img src="../images/new3.jpg" alt="">
				<div class="des">
				    <span>Bewakoof</span>
					<h5>men's Cotton T-shirt</h5>
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
			
			 <div class="pro">
			    <img src="../images/new4.jpg" alt="">
				<div class="des">
				    <span>SIRIL</span>
					<h5>Women's Cotton Saree</h5>
					<div class="star">
					
		            <i class="fas fa-star"></i>
		            <i class="fas fa-star"></i>
					</div>
					<h4>$16</h4>
				</div>
				<div class="cart">
				<a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
				</div>
            </div>
			
			 <div class="pro">
			    <img src="../images/blue-saree.jpg" alt="">
				<div class="des">
				    <span>TAGDO</span>
					<h5>Silk saree</h5>
					<div class="star">
					<i class="fas fa-star"></i>
		            <i class="fas fa-star"></i>
		            <i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
		            <i class="fas fa-star"></i>
					</div>
					<h4>$20</h4>
				</div>
				<div class="cart">
				<a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
				</div>
            </div>
			
			<div class="pro">
			    <img src="../images/new5.jpg" alt="">
				<div class="des">
				    <span>Sidhidata </span>
					<h5>Kanjivaram Banarsi Silk Saree</h5>
					<div class="star">
					     <i class="fas fa-star"></i>
		                       <i class="fas fa-star"></i>
					     <i class="fas fa-star"></i>
		                       <i class="fas fa-star"></i>
		                       <i class="fas fa-star"></i>
					</div>
					<h4>$36</h4>
				</div>
				<div class="cart">
				<a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
				</div>
            </div>
			
			<div class="pro">
			    <img src="../images/Poshax.jpg" alt="">
				<div class="des">
				    <span>Poshax</span>
					<h5>Men's Casual Shirt</h5>
					<div class="star">
					<i class="fas fa-star"></i>
		            <i class="fas fa-star"></i>
		            <i class="fas fa-star"></i>
					</div>
					<h4>$19</h4>
				</div>
				<div class="cart">
				<a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
				</div>
            </div>
			
			<div class="pro">
			    <img src="../images/formal-pants.jpg" alt="">
				<div class="des">
				    <span>U.S Polo</span>
					<h5>Formal pants</h5>
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