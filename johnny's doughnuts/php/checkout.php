<?php 
include("dbconn.inc.php");
include("shared.php");

$conn = dbConnect();

session_start();
if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
} else {
    $userID = '';
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
}

if (isset($_POST['placeOrder'])) {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $address = $_POST['flat'].', '.$_POST['street'].', '.$_POST['city'].', '. $_POST['zipcode'];
    $method = $_POST['method'];

    if(isset($userID)) {
        $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE userID=?");
        $verify_cart->bind_param("i", $userID);
        $verify_cart->execute();
        $verify_cart_result = $verify_cart->get_result();
    } else {
        echo "User ID is not set. Please log in or try again.";
        exit;
    }

    if (isset($_GET['getID'])) {
        $get_product = $conn->prepare("SELECT * FROM `products` WHERE ID=? LIMIT 1");
        $get_product->bind_param("i", $_GET['getID']);
        $get_product->execute();
        $get_product_result = $get_product->get_result();
        
        if ($get_product_result->num_rows > 0) {
            while($fetch_p = $get_product_result->fetch_assoc()){
                $insert_order_query = "INSERT INTO `orders`(ID, userID, name, number, email, address, method, productID, price, qty) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $insert_order = $conn->prepare($insert_order_query);
                if (!$insert_order) {
                    die("Error preparing query: " . $conn->error);
                }
        
                $unique_id = unique_id(); 
                if (!$unique_id) {
                    die("Error generating unique ID");
                }
        
                $insert_order->bind_param("sisssidi", $unique_id, $userID, $name, $number, $email, $address, $method, $fetch_p['ID'], $fetch_p['price'], 1);
                if (!$insert_order->execute()) {
                    die("Error executing query: " . $insert_order->error);
                }
                header('location:order.php');
            }
        } else {
            $warning_msg[] = 'Something went wrong';
        }
    } elseif ($verify_cart_result->num_rows > 0) {
        while($f_cart = $verify_cart_result->fetch_assoc()){
            $insert_order_query = "INSERT INTO `orders`(ID, userID, name, number, email, address, method, productID, price, qty) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $insert_order = $conn->prepare($insert_order_query);
            if (!$insert_order) {
                die("Error preparing query: " . $conn->error);
            }
            function unique_id() {
                return uniqid();
            }
            $unique_id = unique_id(); 
            if (!$unique_id) {
                die("Error generating unique ID");
            }

            $insert_order->bind_param("sisssisidi", $unique_id, $userID, $name, $number, $email, $address, $method, $f_cart['productID'], $f_cart['price'], $f_cart['qty']);
            if (!$insert_order->execute()) {
                die("Error executing query: " . $insert_order->error);
            }
            header('location: order.php');
        }
        if ($insert_order) {
            $delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE userID = ?");
            $delete_cart_id->bind_param("i", $userID);
            $delete_cart_id->execute();
            header('location: order.php');
        }
    } else {
        $warning_msg[] = 'Something went wrong';
    }
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
    <title>Johnny's Doughnuts - Checkout</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel='stylesheet' href='https://ctec4321.llt6715.uta.cloud/termProject/homeStyle.css' type='text/css'>
</head>
<body>
    <?php echo $header; ?>
    <div class="main">
        <div class="banner">
            <h1>checkout summary</h1>
        </div>
        <div class="title2">
            <a href="home.php">home </a><span>/ checkout summary</span>
        </div>
        <section class="checkout">
            <div class="title">
                <img src="img/logo.jpg" class="logo" style="height: 120px; margin-right: 3.5rem;">
            </div>
                <div class="row">
                    <form method="post">
                        <h3>billing details</h3>
                        <div class="flex">
                            <div class="box">
                                <div class="input-field">
                                    <p>name <span>*</span></p>
                                    <input type="text" name="name" required maxlength="50" placeholder="Enter Your first name" class="input">
                                </div>
                                <div class="input-field">
                                    <p>phone number <span>*</span></p>
                                    <input type="number" name="number" required maxlength="10" placeholder="(123)456-7890" class="input">
                                </div>
                                <div class="input-field">
                                    <p>email <span>*</span></p>
                                    <input type="email" name="email" required maxlength="50" placeholder="example@email.com" class="input">
                                </div>
                                <div class="input-field">
                                    <p>payment method <span>*</span></p>
                                    <select name="method" class="input">
                                        <option value="credit card">Credit Card</option>
                                        <option value="debit card">Debit Card</option>
                                    </select>
                                </div>
                                <div class="input-field">
                                    <p>card details <span>*</span></p>
                                    <input type="number" name="card" required maxlength="20" placeholder="Enter your card details" class="input">
                                </div>
                            </div>
                            <div class="box">
                                <div class="input-field">
                                    <p>address line 01 <span>*</span></p>
                                    <input type="text" name="street" required maxlength="50" placeholder="e.g street name" class="input">
                                </div>
                                <div class="input-field">
                                    <p>address line 02</p>
                                    <input type="text" name="flat" maxlength="50" placeholder="e.g flat & building number" class="input">
                                </div>
                                <div class="input-field">
                                    <p>city <span>*</span></p>
                                    <input type="text" name="city" required maxlength="50" placeholder="Enter your city name" class="input">
                                </div>
                                <div class="input-field">
                                    <p>state <span>*</span></p>
                                    <input type="text" name="state" required maxlength="50" placeholder="Enter your state" class="input">
                                </div>
                                <div class="input-field">
                                    <p>zipcode <span>*</span></p>
                                    <input type="text" name="zipcode" required maxlength="6" placeholder="123456" class="input">
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="placeOrder" class="btn">place order</button>
                    </form>
                    <div class="summary">
                        <h3>my bag</h3>
                        <div class="box-container">
                            <?php 
                            $grand_total = 0;
                            if (isset($_GET['getID'])) {
                                $select_get = $conn->prepare("SELECT * FROM `products` WHERE ID=?");
                                $select_get->bind_param("i", $_GET['getID']);
                                $select_get->execute();
                                $select_get_result = $select_get->get_result();
                                while ($fetch_get = $select_get_result->fetch_assoc()) {
                                    $sub_total = $fetch_get['price'];
                                    $grand_total += $sub_total;
                                    ?>
                                    <div class="flex">
                                        <img src="<?= $fetch_get['image']; ?>" class="image">
                                        <div class="product-details">
                                            <h3 class="name"><?= $fetch_get['name']; ?></h3>
                                            <p class="price"><?= $fetch_get['price']; ?>/-</p>
                                        </div>
                                    </div>
                                <?php 
                                }
                            } else {
                                $select_cart = $conn->prepare("SELECT c.*, p.image, p.name, p.price FROM `cart` c INNER JOIN `products` p ON c.productID = p.ID WHERE c.userID=?");
                                $select_cart->bind_param("i", $userID);
                                $select_cart->execute();
                                $select_cart_result = $select_cart->get_result();
                                if ($select_cart_result->num_rows > 0) {
                                    while ($fetch_cart = $select_cart_result->fetch_assoc()) {
                                        $sub_total = ($fetch_cart['qty'] * $fetch_cart['price']);
                                        $grand_total += $sub_total;
                                        ?>
                                        <div class="flex">
                                            <img src="<?= $fetch_cart['image']; ?>" class="image">
                                            <div class="product-details">
                                                <h3 class="name"><?= $fetch_cart['name']; ?></h3>
                                                <p class="price">$<?= $fetch_cart['price']; ?> X <?= $fetch_cart['qty']; ?></p>
                                            </div>
                                        </div>
                                    <?php 
                                    }
                                } else {
                                    echo '<p class="empty">your cart is empty!  <a href="index.php">Start Shopping</a></p>';
                                }
                            }
                            ?>
                        </div>

                        <div class="grand-total"><span>total: </span>$<?= $grand_total ?></div>
                    </div>
            </div>
        </section>
        <?php echo $footer; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include("alert.php"); ?>
</body>
</html>
