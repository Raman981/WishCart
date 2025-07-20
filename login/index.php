<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Signup</title>
    <link rel="stylesheet" href="index.css?v=<?php echo time(); ?>">
    
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
	integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" 
	crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container">
	<div class="curved-shape"></div>
	<div class="curved-shape2"></div>
	    <div class="form-box login">
		    <h2 class="animation" style="--D:0; --S:21">Login</h2>
			<form action="login.php" method="POST">
			    <div class="input-box animation" style="--D:1; --S:22">
				    <input type="text" name="Name" required>
					<label for="">Username</label>
					<i class="fa-solid fa-user"></i>
				</div>
				
				 <div class="input-box animation" style="--D:1; --S:22">
				    <input type="email" name="email" required>
					<label for="">Email</label>
					<i class="fa-solid fa-envelope"></i>
				</div>
				<div class="input-box animation" style="--D:2; --S:23">
				    <input type="password" name="password" required>
					<label for="">Password</label>
					<i class="fa-solid fa-lock"></i>
				</div>
				<div class="input-box animation" style="--D:3; --S:24">
				<button class="btn" type="submit" name="signIn">Login</button>
				</div>
				<div class="regi-link animation" style="--D:4; --S:25">
				    <p>Don't have an account ? <a href="#" class="Signuplink">Create an Account</a></p>
				</div>
			</form>
		</div>
		<div class="info-content Login">
		<h2 class="animation" style="--D:0; --S:20">WELCOME BACK</h2>
		<p class="animation" style ="--D:1; --S:21"> Welcome back!<br>
		    Exciting deals are<br>
		    waiting for you!</p>
		</div>
		<div class="form-box Register">
		    <h2 class="animation" style="--li:17; --S:0;">Register</h2>
			<form action="register.php" method="POST">
			    <div class="input-box animation" style="--li:18; --S:1;">
				    <input type="text" name="Name" required>
					<label for="">Username</label>
					<i class="fa-solid fa-user"></i>
				</div>
				<div class="input-box animation" style="--li:18; --S:1;">
				    <input type="email" name="email"required>
					<label for="">Email</label>
					<i class="fa-solid fa-envelope"></i>
				</div>
				<div class="input-box animation" style="--li:19; --S:2;">
				    <input type="password" name="password" required>
					<label for="">Password</label>
					<i class="fa-solid fa-lock"></i>
				</div>
				<div class="input-box animation" style="--li:20; --S:3;">
				<button class="btn" type="submit" name="signUp">Register</button>
				</div>
				<div class="regi-link animation" style="--li:21; --S:4;">
				    <p>Don't have an account ? <a href=" # "class="SignInlink"> sign in </a></p>
				</div>
			</form>
		</div>
		<div class="info-content Register">
		<h2 class="animation" style="--li:17; --S:0;">WELCOME TO WISHCART</h2>
		<p class="animation" style="--li:18; --S:1;">Create an account & start<br>
		   your shopping journey!
		   </p>
		</div>
	</div>

    <script src="index.js"></script>
</body>
</html>
