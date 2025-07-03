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

    if (isset($_POST['submit'])) {
        $ID = uniqid('', true);
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $pass = $_POST['pass'];
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);
        $cpass = $_POST['cpass'];
        $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

        $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
        $select_user->bind_param("s", $email); 
        $select_user->execute();
        $result = $select_user->get_result(); 
        $num_rows = $result->num_rows;
        
        if ($num_rows > 0) {
            $warning_msg[] = 'This email already exists';
        } else {
            if($pass != $cpass) {
                $warning_msg[] = 'Confirm your password';
            } else {
                $insert_user = $conn->prepare("INSERT INTO `users`(ID, name, email, password) VALUES(?,?,?,?)");
                $insert_user->bind_param("ssss", $ID, $name, $email, $pass);
                $insert_user->execute(); 
                
                $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
                $select_user->bind_param("ss", $email, $pass); 
                $select_user->execute();
                $result = $select_user->get_result();
                
                if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $_SESSION['userID'] = $row['ID'];
                $_SESSION['name'] = $name; 
                $_SESSION['email'] = $email;
                header('location: index.php');
                exit();
            }
            }
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
    <title>Johnny's Doughnuts - Register</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel='stylesheet' href='https://ctec4321.llt6715.uta.cloud/termProject/homeStyle.css' type='text/css'>
</head>
<body>
    <div class="main-container">
        <section class="form-container">
            <div class="title">
                <a href="index.php" class="logo"><img src="img/logo.jpg" style="height: 120px; margin-right: 3rem;"></a>
                <h1>CREATE ACCOUNT</h1>
            </div>
            <form action="" method="post" class="login-form">
                <div class="input-field">
                    <p class="name">Name <sup>*</sup></p>
                    <input type="text" name="name" required placeholder="Enter your name" maxlength="50">
                </div>
                <div class="input-field">
                    <p class="name">email <sup>*</sup></p>
                    <input type="email" name="email" required placeholder="Enter your email" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p class="name">password <sup>*</sup></p>
                    <input type="password" name="pass" required placeholder="Enter your password" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p class="name">confirm password <sup>*</sup></p>
                    <input type="password" name="cpass" required placeholder="Confirm your password" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <input type="submit" name="submit" value="Register Now" class="btn">
                <br>
                <p>Already have an account? <a href="login.php">Login now</a></p>
            </form>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php include("alert.php"); ?>
</body>
</html>
