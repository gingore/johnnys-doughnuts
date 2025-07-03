<?php 
session_start();

function uniqueID() {
    return uniqid('cart_');
}

$conn = new mysqli("localhost", "llt6715_admin", "Junbies836729", "llt6715_donuts");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;

$header = '<header class="header">
    <div class="flex">
        <a href="index.php" class="logo"><img src="img/logo-banner.jpg" style="height: 100px; width: 100%; margin-right: -2rem; padding-bottom: 1rem;"></a>
        <nav class="navbar">
            <a href="index.php">home</a>
            <a href="about.php">about us</a>
            <a href="products.php">products</a>
            <a href="contact.php">contact us</a>
        </nav>
        <div class="icons">
            <i class="bx bxs-user" id="user-btn"></i>';
            
$count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE userID = ?");
$count_cart_items->bind_param("i", $userID);
$count_cart_items->execute();
$count_cart_items->store_result();
$total_cart_items = $count_cart_items->num_rows;

$header .= '<a href="cart.php" class="cart-btn"><i class="bx bx-cart-download"></i><sup>'.$total_cart_items.'</sup></a>
            <i class="bx bx-list-plus" id="menu-btn" style="font-size: 2rem;"></i>
        </div>
        <div class="user-box">';
        
        if (isset($_SESSION['name'])) {
            $header .= '<p>USERNAME : <span>'.$_SESSION['name'].'</span></p>';
        } else {
            $header .= '<p>USERNAME : <span></span></p>'; // Or handle it 
        }
        if (isset($_SESSION['email'])) {
            $header .= '<p>EMAIL : <span>'.$_SESSION['email'].'</span></p>';
        } else {
            $header .= '<p>EMAIL : <span></span></p>'; 
        }
        
        $header .= '<a href="login.php" class="btn" style="color: #fff;">login</a>
                    <a href="register.php" class="btn" style="color: #fff;">register</a>
                    <form method="post">
                        <button type="submit" name="logout" class="logout-btn">log out</button>
                    </form>
                </div>
            </div>
        </header>';


$footer = '<footer>
    <div class="overlay"></div>
    <div class="footer-content">
        <div class="inner-footer">
            <div class="card">
                <h3>Quicklinks</h3>
                <ul>
                    <li><a href="index.php">home</a></li>
                    <li><a href="about.php">about us</a></li>
                    <li><a href="products.php">products</a></li>
                    <li><a href="contact.php">contact us</a></li>
                </ul>
            </div>
            <div class="card">
                <h3>Hours of Operation</h3>
                <ul>
                    <li><span>Mon - Thurs:</span> <span>4AM - 1PM</span></li>
                    <li><span>Friday:</span> <span>5AM - 2PM</span></li>
                    <li><span>Saturday:</span> <span>6AM - 3PM</span></li>
                    <li><span>CLOSED SUNDAYS</span></li>
                </ul>
            </div>
            <div class="card">
                <h3>Socials</h3>
                <p>Connect With Us!</p>
                <div class="social-links">
                    <i class="bx bxl-instagram"></i>
                    <i class="bx bxl-twitter"></i>
                </div>
            </div>
        </div>
        <div class="bottom-footer">
            <p>This is a CTEC 4309 Term Project - Not an official website. &copy All rights reserved. <a href="privacy_policy.html" class="policy">View our Privacy Policy</a></p>
        </div>
    </div>
</footer>';

?>
