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
    	<title>Johnny's Doughnuts - Home</title>
    	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    	<link rel='stylesheet' href='https://ctec4321.llt6715.uta.cloud/termProject/homeStyle.css' type='text/css'>
    </head>

<body>
	<?php echo $header; ?>
	<div class="main">
		
		<section class="home-section">
			<div class="slider">
				<div class="slider__slider slide1">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>Try Our New Seasonal Flavors</h1>
                        <p>Explore our seasonal flavors and unique creations, each crafted to surprise and delight your taste buds.</p>
                        <a href="products.php" class="btn">shop now</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>
				<!-- slide end -->
				<div class="slider__slider slide2">
					<div class="overlay"></div>
					<div class="slide-detail">
						<h1>Treat Yourself to a Dozen</h1>
						<p>Delight in a dozen of our delectable doughnuts, perfect for sharing with friends and family or savoring all to yourself.</p>
						<a href="products.php" class="btn">shop now</a>
					</div>
					<div class="hero-dec-top"></div>
					<div class="hero-dec-bottom"></div>
				</div>
				<!-- slide end -->
				<div class="slider__slider slide4">
					<div class="overlay"></div>
					<div class="slide-detail">
						<h1>Order Online</h1>
						<p>Skip the line and order your favorite doughnuts online from the comfort of your home.</p>
						<a href="products.php" class="btn">shop now</a>
					</div>
					<div class="hero-dec-top"></div>
					<div class="hero-dec-bottom"></div>
				</div>
				<!-- slide end -->
				<div class="left-arrow"><i class='bx bxs-left-arrow'></i></div>
                <div class="right-arrow"><i class='bx bxs-right-arrow'></i></div>
			</div>
		</section>
		<!-- home slider end -->
		<section class="shop">
			<div class="title">
				<h1>Today's Top Treats</h1>
			</div>
			<div class="box-container">
				<div class="box">
					<a href="products.php"><img src="img/choco-cream.jpg"></a>
					<h2>CHOCOLATE CREAM DOUGHNUT</h2>
				</div>
				<div class="box">
					<a href="products.php"><img src="img/glaze.jpg"></a>
					<h2>CLASSIC GLAZED DOUGHNUT</h2>
				</div>
				<div class="box">
					<a href="products.php"><img src="img/strawberry.jpg"></a>
					<h2>STRAWBERRY SPRINKLE DOUGHNUT</h2>
				</div>
				<div class="box">
					<a href="products.php"><img src="img/blueberry.jpg"></a>
					<h2>BLUEBERRY CAKE DOUGHNUT</h2>
				</div>
			</div>
		</section>

		<section class="shop-category">
			<div class="box-container">
				<div class="box">
				    <div class="overlay"></div> 
					<img src="img/donuts.jpg">
					<div class="detail">
						<span>CURRENT OFFERS</span>
						<h1>EXTRA 15% OFF</h1>
						<a href="products.php" class="btn">shop now</a>
					</div>
				</div>
				<div class="box">
				    <div class="overlay"></div> 
					<img src="img/donuts2.jpg">
					<div class="detail">
						<span>NEW IN!</span>
						<h1>SEASONAL FLAVORS</h1>
						<a href="products.php" class="btn">shop now</a>
					</div>
				</div>
			</div>
		</section>
		<section class="thumb">
			<div class="box-container">
				<div class="box">
					<img src="img/thumb2.jpg">
					<h3>Fresh Ingredients</h3>
					<p>Indulge in our delights crafted with only the freshest, finest ingredients, ensuring a taste that's pure and delightful.</p>
				</div>
				<div class="box">
					<img src="img/thumb0.jpg">
					<h3>Made Daily</h3>
					<p>Experience the warmth and freshness of our handmade treats, baked with love and care every single day for you.</p>
				</div>
				<div class="box">
					<img src="img/thumb1.jpg">
					<h3>Locally Loved</h3>
					<p>Become a part of our community's cherished tradition by starting your mornings with our sweet delights.</p>
				</div>
				<div class="box">
					<img src="img/thumb.jpg">
					<h3>Crafted with Care</h3>
					<p>Each of our creations are meticulously crafted to bring a little extra joy to your day, making every bite a moment to savor.</p>
				</div>
			</div>
		</section>
		<?php echo $footer; ?>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="slider.js"></script>
	<script src="script.js"></script>

	<?php include ("alert.php"); ?>
</body>
</html>