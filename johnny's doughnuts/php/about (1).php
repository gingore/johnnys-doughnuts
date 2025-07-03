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
    	<title>Johnny's Doughnuts - About Us</title>
    	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    	<link rel='stylesheet' href='https://ctec4321.llt6715.uta.cloud/termProject/homeStyle.css' type='text/css'>
    </head>
<body>
	<?php echo $header; ?>
	<div class="main">
		<div class="banner">
			<h1>about us</h1>
		</div>
		<div class="title2">
			<a href="index.php">home </a><span>/ about</span>
		</div>
		<section class="services">
		    <div class="title">
				<img src="img/logo.jpg" class="about-logo">
				<h1>who we are</h1>
				<p>At Johnny’s Doughnuts, we pour our hearts into every delicious treat we make. Established in 2006 in the heart of Midland, TX. What started as a testament of a Mother's love for her son has blossomed into a local treasure, known for our variety of fresh made doughnuts and other treats. Each bite is a taste of tradition, made with care, so that every visit to Johnny’s Doughnuts is a memorable experience.
                </p>
			</div>
			<br>
			<div class="title">
				<h1>why choose us</h1>
				<p>When you choose Johnny’s Doughnuts, you’re choosing more than just a doughnut shop. You’re choosing quality, passion, and a taste of home. Our commitment to excellence shines through in every bite. With a wide variety of treats, from classic favorites to our own creations, there’s something for everyone at Johnny’s Doughnuts. Join our loyal community of customers in Midland, TX who have come to cherish on us for treats made with love, and experience the difference that sets us apart.
                </p>
			</div>
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
			<div class="testimonial-container">
			<div class="title">
				<h1>what people say about us</h1>
            </div>
                <div class="container">
                	<div class="testimonial-item active">
                		<img src="img/01.jpg" style="height: 120px">
                		<h1>Melissa S.</h1>
                		<p class="testimonial-line">Just moved to Midland and came across Johnny's Doughnuts. Best Apple fritter I've had and the cinnamon rolls are top notch. They taste like a huge glazed doughnut with cinnamon. Cake doughnuts are all great, especially the chocolate on chocolate!</p>
                	</div>
                	<div class="testimonial-item">
                		<img src="img/02.jpg" style="height: 120px">
                		<h1>Ashley J.</h1>
                		<p class="testimonial-line">the best donuts in midland !!! hands down very well priced good service and lots of options<p>
                	</div>
                	<div class="testimonial-item">
                		<img src="img/03.jpg" style="height: 120px">
                		<h1>Kathlyn G.</h1>
                		<p class="testimonial-line">This is the best doughnut shop I've ever had!!! The owners are very nice. They keep their place very clean and tidy! They are just the best!!</p>
                	</div>
                	<div class="testimonial-item">
                		<img src="img/01.jpg" style="height: 120px">
                		<h1>Bennie A.</h1>
                		<p class="testimonial-line">My family loves this place and believes this is the best donuts in town. I love the extra cinnamon roll or the maple glazed cinnamon roll. My wife thinks they have the best apple fritters in town. I have also had their maple glazed long johns and they are good.</p>
                	</div>
                	<div class="left-arrow" onclick="nextSlide()"><i class="bx bxs-left-arrow-alt"></i></div>
                	<div class="right-arrow" onclick="prevSlide()"><i class="bx bxs-right-arrow-alt"></i></div>
                </div>
		</div>
		<?php echo $footer; ?>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="script.js"></script>
	<script type="text/javascript">
		let slides = document.querySelectorAll('.testimonial-item');
		let index = 0;

		function nextSlide(){
		    slides[index].classList.remove('active');
		    index = (index + 1) % slides.length;
		    slides[index].classList.add('active');
		}
		function prevSlide(){
		    slides[index].classList.remove('active');
		    index = (index - 1 + slides.length) % slides.length;
		    slides[index].classList.add('active');
		}
	</script>
	<?php include("alert.php"); ?>
</body>
</html>