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

	// Log in user
	if (isset($_POST['submit'])) {

		$email = $_POST['email'];
		$email = filter_var($email, FILTER_SANITIZE_STRING);
		$password = $_POST['password'];
		$password = filter_var($password, FILTER_SANITIZE_STRING);

		$select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
		$select_user->bind_param("ss", $email, $password);
		$select_user->execute(); 
		$result = $select_user->get_result(); 
		$row = $result->fetch_assoc();

		if ($result->num_rows > 0) {
			$_SESSION['userID'] = $row['ID'];
			$_SESSION['name'] = $row['name'];
			$_SESSION['email'] = $row['email'];
			header('location: index.php');
		} else {
			$warning_msg[] = 'Incorrect email or password';
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
    <title>Johnny's Doughnuts - Login</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel='stylesheet' href='https://ctec4321.llt6715.uta.cloud/termProject/homeStyle.css' type='text/css'>
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <a href="index.php" class="logo"><img src="img/logo.jpg" style="height: 120px; margin-right: 3rem;"></a>
                <h1>Login</h1>
            </div>
            <form action="" method="post" class="login-form">
                <div class="input-field">
                    <p class="name">Email <sup>*</sup></p>
                    <input type="email" name="email" required placeholder="Enter your email" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p class="name">Password <sup>*</sup></p>
                    <input type="password" name="password" required placeholder="Enter your password" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                
                <input type="submit" name="submit" value="Login Now" class="btn">
                <br>
                <p>Don't have an account yet? <a href="register.php">Register now</a></p>
            </form>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php include("alert.php"); ?>
</body>
</html>
