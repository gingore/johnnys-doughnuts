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
    
    // Adding products to cart
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
        <title>Johnny's Doughnuts - Products</title>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel='stylesheet' href='https://ctec4321.llt6715.uta.cloud/termProject/homeStyle.css' type='text/css'>
    </head>
<body>
    <?php echo $header; ?>
    <div class="main">
        <div class="banner">
            <h1>Shop</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home </a><span>/ Products</span>
        </div>
        <section class="products">
            <div class="box-container">
                <?php 
                    $select_products = $conn->prepare("SELECT * FROM `products`");
                    $select_products->execute();
                    $result = $select_products->get_result();
                    if ($result->num_rows > 0) {
                        while ($fetch_products = $result->fetch_assoc()) {
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="box">
                    <img src="<?php echo $fetch_products['image']; ?>" class="img">
                    <h3 class="name"><?php echo $fetch_products['name']; ?></h3>
                    <input type="hidden" name="productID" value="<?php echo $fetch_products['ID']; ?>">
                    <div class="flex">
                        <p class="price">Price: $<?php echo $fetch_products['price']; ?></p>
                        <input type="number" name="qty" required min="1" value="1" max="20" class="qty">
                        <div class="button">
                            <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                            <a href="view_page.php?pid=<?php echo $fetch_products['ID']; ?>" class="bx bxs-show"></a>
                        </div>
                    </div>
                </form>
                <?php 
                        }
                    } else {
                        echo '<p class="empty">No products have been added yet! Please check again another time.</p>';
                    }
                ?>
            </div>
        </section>
        <?php echo $footer; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include ("alert.php"); ?>
</body>
</html>
