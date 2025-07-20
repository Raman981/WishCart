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
      <meta name="viewport" content="width=device-width , initial-scale=1.0">
      <title> WishCart</title>
	   <link rel="stylesheet" href="CSS/style.css?v=<?php echo time(); ?>">

    
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
	 integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" 
	 crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>


<?php
$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql);
?>

      <section id="header">
         <a href="Home.php"><img src="../images/wishcart.png" class="logo" alt=""></a>   

            <div>
                  <ul id="navbar">
				      <li><a  href="Home.php">Home</a></li>
                              <li><a class="active" href="shop.php">Shop</a></li>
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
		<?php
		if(isset($display_message)){
			echo "<div class='display_message'>
			           <span>$dispaly_message,/span>
			           <i class='fas fa-times' onClick='this.parentElement.style.display=`none`';></i>	
		       </div>";
		}
		?>
		
			
			<div id="mobile">
				<a href="cart.html"><i class="fa-solid fa-cart-shopping"></i></a>
				<li id="lg-bag"><a href="profile.php" class="profile-icon"><i class="fas fa-user"></i></a></li>
				<i id="bar" class="fas fa-outdent"></i>
			</div>
			
      </section>
	    
	    <section id="Page-header">
	        <h2> Try Brand New </h2>
	        <p> Save more with coupons & up to 70% off!</p>
			
			<div class="Search-bar">
			    <input type="text" placeholder="Search products..."/>
				<button><i class="fa-solid fa-magnifying-glass"></i></button>
			</div>
	    </section>
	  
	    
	  <section id="product" class="section-p2">
	    <h2> Featured Products</h2>
		<p> Summer Collections New Mordern Design</p>
		<div class="pro-container">
                  <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <div class="pro">
                            <img src="../images/<?php echo $row['image']; ?>" alt="">
                              <div class="des">
                                    <span><?php echo $row['Company']; ?></span>
                                    <h5><?php echo $row['NAME']; ?></h5>
                                    <div class="star">
                                          <?php
                                                $rating = $row['Rating'];
                                                for ($i = 0; $i < $rating; $i++) {
                                                echo '<i class="fas fa-star"></i>';
                                                }
                                                for ($i = $rating; $i < 5; $i++) {
                                                echo '<i class="far fa-star"></i>';
                                                }
                                          ?>
                                    </div>

                                          <h4>₹<?php echo $row['price']; ?></h4>
                              </div>

                                              <!------ Add-to-cart form ------>
                                          <form class="add-to-cart-form" method="POST">
                                                <input type="hidden" name="product_id" value="<?php echo $row['product_ID']; ?>">
                                                <input type="hidden" name="product_name" value="<?php echo $row['NAME']; ?>">
                                                <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" name="add_to_cart" class="cart">
                                                      <i class="fa-solid fa-cart-shopping"></i>
                                                </button>
                                          </form>

                         </div>
                  <?php } ?>
      


		    
		      <div class="pro">
			    <img src="../images/white-black.jpg" alt="">
				<div class="des">
				    <span>Leriya Fashion </span>
					<h5>shirt for men ||Printed</h5>
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
				  
				</div>
                   </div>

			
			 <div class="pro">
			    <a href="sproducts/sproduct2.php"> <img src="../images/black-white.jpg" alt="">
				<div class="des">
				    <span>HMKM</span>
					<h5>Casual Regular fit shirt</h5>
					<div class="star">
		            <i class="fas fa-star"></i>
		            <i class="fas fa-star"></i>
					</div>
					<h4>$55</h4>
				</div>
				<div class="cart">
				    <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
				</div>
                  </div>
			
			 <div class="pro">
			    <img src="../images/lookmark.jpg" alt="">
				<div class="des">
				    <span>LOOKMARK</span>
					<h5>Men's Printed Regular shirt</h5>
					<div class="star">
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
			    <img src="../images/tagdo.jpg" alt="">
				<div class="des">
				    <span>TAGDO</span>
					<h5>Men's solid shirt</h5>
					<div class="star">
					<i class="fas fa-star"></i>
		            <i class="fas fa-star"></i>
		            <i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
		            <i class="fas fa-star"></i>
					</div>
					<h4>$30</h4>
				</div>
				<div class="cart">
				    <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
				</div>
                  </div>
			
			
			<div class="pro">
			    <img src="../images/white-shoes.jpg" alt="">
				<div class="des">
				    <span>PUMA</span>
					<h5>casual jogger shoes</h5>
					<div class="star">
					<i class="fas fa-star"></i>
		            <i class="fas fa-star"></i>
		            <i class="fas fa-star"></i>
					</div>
					<h4>$60</h4>
				</div>
				<div class="cart">
				    <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
				</div>
                  </div>
			
			<div class="pro">
			    <img src="../images/yorichi.jpg" alt="">
				<div class="des">
				    <span>yorichi</span>
					<h5>Gojo Satoru casual shirt</h5>
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
	  
	    <section id="product" class="section-p2">
	        <h2> New Arrivals</h2>
		    <p> Summer Collections New Mordern Design</p>
		    <div class="pro-container">
		    <div class="pro">
			    <img src="../images/modern-dress.jpg" alt="">
				<div class="des">
				    <span>LOOKMARK</span>
					<h5>Formal womens dress</h5>
					<div class="star">
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
		            <i class="fas fa-star"></i>
		            <i class="fas fa-star"></i>
					</div>
					<h4>$32</h4>
				</div>
				<div class="cart">
				<a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
				</div>
            </div>
			
			 <div class="pro">
			    <img src="../images/white-blue.jpg" alt="">
				<div class="des">
				    <span>HMKM</span>
					<h5>Casual Regular fit shirt</h5>
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
			    <img src="../images/blue-suit.jpg" alt="">
				<div class="des">
				    <span>LOOKMARK</span>
					<h5>White Blue Suit Salwar</h5>
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
			    <img src="../images/Poshax.jpg" alt="">
				<div class="des">
				    <span>POHSAX</span>
					<h5>Men's casual shirt</h5>
					<div class="star">
					
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
					<h4>$70</h4>
				</div>
				<div class="cart">
				<a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
				</div>
            </div>
			
			<div class="pro">
			    <img src="../images/formal-men-dress.jpg" alt="">
				<div class="des">
				    <span>HKMK </span>
					<h5>shirt for men</h5>
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
			    <img src="../images/red-shoes.jpg" alt="">
				<div class="des">
				    <span>Ajanta</span>
					<h5>Red casual shoe</h5>
					<div class="star">
					<i class="fas fa-star"></i>
		            <i class="fas fa-star"></i>
		            <i class="fas fa-star"></i>
					</div>
					<h4>$69</h4>
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
<script>
document.querySelectorAll(".add-to-cart-form").forEach(form => {
    form.addEventListener("submit", function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch("add_to_cart.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(data => {
            // 👇 Use the actual PHP response
            alert(data.trim());

            // 🔁 Update cart count
            fetch("get_cart_count.php")
                .then(res => res.text())
                .then(count => {
                    const cartCountElement = document.querySelector(".cart-count");
                    if (cartCountElement) {
                        cartCountElement.textContent = count;
                    }
                });
        })
        .catch(error => {
            console.error("Error:", error);
            alert("⚠️ Failed to add item.");
        });
    });
});
</script>


</body>
</html>