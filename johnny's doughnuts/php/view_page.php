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

    if (isset($_POST['add_to_cart'])) {
        $ID = uniqueID();
        $productID = $_POST['productID'];

        $qty = $_POST['qty'];
        $qty = filter_var($qty, FILTER_SANITIZE_STRING);

        $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE userID = ? AND productID = ?");
        $verify_cart->bind_param("ii", $userID, $productID);
        $verify_cart->execute();
        $verify_cart->store_result();

        $max_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE userID = ?");
        $max_cart_items->bind_param("i", $userID);
        $max_cart_items->execute();
        $max_cart_items->store_result();

        if ($verify_cart->num_rows > 0) {
            $warning_msg[] = 'Product already exists in your cart';
        } else if ($max_cart_items->num_rows > 20) {
            $warning_msg[] = 'Cart is full';
        } else {
            $select_price = $conn->prepare("SELECT * FROM `products` WHERE ID = ? LIMIT 1");
            $select_price->bind_param("i", $productID);
            $select_price->execute();
            $result = $select_price->get_result();
            $fetch_price = $result->fetch_assoc();

            $insert_cart = $conn->prepare("INSERT INTO `cart`(ID, userID, productID, price, qty) VALUES(?, ?, ?, ?, ?)");
            $insert_cart->bind_param("siiid", $ID, $userID, $productID, $fetch_price['price'], $qty);
            $insert_cart->execute();
            $success_msg[] = 'Product added to cart successfully!';
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
        <title>Johnny's Doughnuts - Product Details</title>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='https://ctec4321.llt6715.uta.cloud/termProject/homeStyle.css' type='text/css'>
    </head>
<body>
    <?php echo $header; ?>
    <div class="main">
        <div class="banner">
            <h1>product details</h1>
        </div>
        <div class="title2">
            <a href="index.php">home </a><span>/ product details</span>
        </div>
        <section class="view_page">
            <?php 
                if (isset($_GET['pid'])) {
                    $pid = $_GET['pid'];
                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE ID = ?");
                    $select_products->bind_param("i", $pid);
                    $select_products->execute();
                    $result = $select_products->get_result();
                    if ($result->num_rows > 0) {
                        while($fetch_products = $result->fetch_assoc()){


            ?>
            <form method="post">
                <img class="product-image" src="<?php echo $fetch_products['image']; ?>">
                <div class="detail">
                    <div class="name"><?php echo $fetch_products['name']; ?></div>
                    <div class="price">$<?php echo $fetch_products['price']; ?></div>
                    <div class="detail">
                        <?php 
                            if (isset($fetch_products['productDetail'])) {
                                echo "<p>" . $fetch_products['productDetail'] . "</p>";
                            } else {
                                echo "<p>No description available.</p>";
                            }
                        ?>
                    </div>
                    <input type="hidden" name="productID" value="<?php echo $fetch_products['ID']; ?>">
                    <div class="button">
                        <input type="hidden" name="qty" value="1" min="0" class="quantity">
                        <button type="submit" name="add_to_cart" class="btn">add to cart<i class="bx bx-cart"></i></button>
                    </div>
                </div>
            </form>
            <?php 
                        }
                    }
                }
            ?>
        </section>
        <?php echo $footer; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include ("alert.php"); ?>
</body>
</html>
