<?php 
    include("dbconn.inc.php");
    include("shared.php");
    
    $conn = dbConnect();
    
 session_start();
 if (isset($_SESSION['userID'])) {
		$userID = $_SESSION['userID'];
	}else{
		$userID = '';
	}

	if (isset($_POST['logout'])) {
		session_destroy();
		header("location: login.php");
	}
?>

<style type="text/css">
	<?php include 'style.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">
    <head>
    	<meta charset="UTF-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<title>Johnny's Doughnuts - Contact</title>
    	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    	<link rel='stylesheet' href='https://ctec4321.llt6715.uta.cloud/termProject/homeStyle.css' type='text/css'>
    </head>
<body>
	<?php echo $header; ?>
	<div class="main">
		<div class="banner">
			<h1>contact us</h1>
		</div>
		<div class="title2">
			<a href="index.php">home </a><span>/ contact us</span>
		</div>
		<div class="form-container">
			 <form method="post">
			 	<div class="title">
			 		<img src="img/logo.jpg" class="logo">
			 		<h1>leave  us a message</h1>
			 	</div>
			 	<div class="input-field">
			 		<p>name <sup>*</sup></p>
			 		<input type="text" name="name" placeholder="First Name">
			 	</div>
			 	<div class="input-field">
			 		<p>email <sup>*</sup></p>
			 		<input type="email" name="email" placeholder="e.g. name@email.com">
			 	</div>
			 	<div class="input-field">
			 		<p>phone number <sup>*</sup></p>
			 		<input type="text" name="number" placeholder="(432)123-4567">
			 	</div>
			 	<div class="input-field">
			 		<p>message <sup>*</sup></p>
			 		<textarea name="message" placeholder="Type your message here"></textarea>
			 	</div>
			 	<button type="submit" name="submit-btn" class="btn">send message</button>
			 </form>
		</div>
		<div class="address">
			 	<div class="title">
			 		<h1>contact us</h1>
			 	</div>
			 	<div class="box-container">
			 		<div class="box">
			 			<i class="bx bxs-map-pin"></i>
			 			<div>
			 				<h4>address</h4>
			 				<p class="address-text">2111 N Big Spring St, Midland, TX</p>
			 			</div>
			 		</div>
			 		<div class="box">
			 			<i class="bx bxs-phone-call"></i>
			 			<div>
			 				<h4>phone number</h4>
			 				<p class="phone">(432) 686-7400</p>
			 			</div>
			 		</div>
			 		<div class="box">
			 			<i class="bx bxs-map-pin"></i>
			 			<div>
			 				<h4>email</h4>
			 				<p>inquiry@johnnysdoughtnuts.com</p>
			 			</div>
			 		</div>
			 	</div>
			 </div>
		<?php echo $footer; ?>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="script.js"></script>
	<?php include ("alert.php"); ?>
</body>
</html>