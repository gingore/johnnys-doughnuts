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

function updateCartCountSession() {
    global $userID, $conn;

    $count_cart_items = $conn->query("SELECT * FROM `cart` WHERE userID = '$userID'");
    $total_cart_items = $count_cart_items->num_rows;

    $_SESSION['cart_count'] = $total_cart_items;
}

if (isset($_POST['updateCart'])) {
    $cartID = $_POST['cartID'];
    $cartID = filter_var($cartID, FILTER_SANITIZE_STRING);
    $qty = $_POST['qty'];
    $qty = intval($qty);

    $update_qty = $conn->query("UPDATE `cart` SET qty = '$qty' WHERE ID = '$cartID'");

    $success_msg[] = 'Cart updated successfully!';

    updateCartCountSession();
}

if (isset($_POST['delete_item'])) {
    $cartID = $_POST['delete_item'];
    $cartID = filter_var($cartID, FILTER_SANITIZE_STRING);

    $verify_delete_items = $conn->query("SELECT * FROM `cart` WHERE ID = '$cartID'");

    if ($verify_delete_items->num_rows > 0) {
        $delete_cart_id = $conn->query("DELETE FROM `cart` WHERE ID = '$cartID'");
        $success_msg[] = "Cart item deleted successfully!";
    } else {
        $warning_msg[] = 'Cart item already deleted';
    }

    updateCartCountSession();
}

//empty cart
if (isset($_POST['empty_cart'])) {
    $verify_empty_item = $conn->query("SELECT * FROM `cart` WHERE userID = '$userID'");

    if ($verify_empty_item->num_rows > 0) {
        $delete_cart_id = $conn->query("DELETE FROM `cart` WHERE userID = '$userID'");
        $success_msg[] = "Cart emptied successfully!";
    } else {
        $warning_msg[] = 'Cart item already deleted';
    }

    updateCartCountSession();
}

// Calculate grand total
$grand_total = 0;

$select_cart = $conn->prepare("SELECT SUM(products.price) AS total_price FROM `cart` INNER JOIN `products` ON cart.productID = products.ID WHERE cart.userID = ?");
$select_cart->bind_param("i", $userID);
$select_cart->execute();
$result = $select_cart->get_result();

if ($result->num_rows > 0) {
    $fetch_cart = $result->fetch_assoc();
    $grand_total = $fetch_cart['total_price'];
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
    <title>Johnny's Doughnuts - Cart</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel='stylesheet' href='https://ctec4321.llt6715.uta.cloud/termProject/homeStyle.css' type='text/css'>
</head>
<body>
    <?php echo $header; ?>
    <div class="main">
        <div class="banner">
            <h1>My Cart</h1>
        </div>
        <div class="title2">
            <a href="index.php">Home</a><span>/ Cart</span>
        </div>
        <section class="products">
            <h1 class="title">Products Added to Cart</h1>
            <div class="box-container">
                <?php 
                $grand_total = 0;
                $select_cart = $conn->prepare("SELECT cart.*, products.name, products.image, products.price FROM `cart` INNER JOIN `products` ON cart.productID = products.ID WHERE cart.userID = ?");
                $select_cart->bind_param("i", $userID);
                $select_cart->execute();
                $result = $select_cart->get_result();
                if ($result->num_rows > 0) {
                    while($fetch_cart = $result->fetch_assoc()){
                        $qty = $fetch_cart['qty'];
                        $price = $fetch_cart['price'];
                        $sub_total = $qty * $price;
                        
                ?>
                
                <form method="post" action="cart.php" class="box">
                    <input type="hidden" name="cartID" value="<?=$fetch_cart['ID']; ?>">
                    <!-- Display product image -->
                    <img src="<?=$fetch_cart['image']; ?>" class="img">
                    <h3 class="name"><?=$fetch_cart['name']; ?></h3>
                    <div class="flex">
                        <p class="price">Price: $<?=$fetch_cart['price']; ?></p>
                        <input type="number" name="qty" required min="1" value="<?=$fetch_cart['qty']; ?>" max="99" maxlength="2" class="qty">
                        <button type="submit" name="updateCart" class="bx bxs-edit fa-edit"></button>
                    </div>
                    <?php $sub_total = $fetch_cart['qty'] * $fetch_cart['price']; ?>
                    <p class="sub-total">Subtotal: <span>$<?= number_format($sub_total, 2); ?></span></p>
                    <button type="submit" name="delete_item" value="<?= $fetch_cart['ID']; ?>" class="btn" onclick="return confirm('Delete this item?')">Delete</button>
                </form>
                <?php 
                            $grand_total+=$sub_total;
                    }
                } else {
                    echo '<p class="empty">No products added yet! <a href="products.php">Start shopping</a></p>';
                }
                ?>
                
            </div>
            <?php 
            if ($grand_total !=0) {
            ?>
            <div class="cart-total">
                <p>Total: <span>$ <?= $grand_total; ?></span></p>
                <div class="button">
                    <form method="post">
                        <button type="submit" name="empty_cart" class="btn" onclick="return confirm('Are you sure you want to empty your cart?')">Empty Cart</button>
                    </form>
                    <a href="checkout.php" class="btn">Checkout</a>
                </div>
            </div>
            <?php } ?>
        </section>
        <?php echo $footer; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</body>
</html>
