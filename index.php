<?php
    session_start();
    if (isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: home.php");
        die();
    }
    // Create login database
    require_once('php/CreateDb.php');
    $database = new CreateLoginDb(dbname:"login", tablename:"users");
    include 'config.php'; 
    $msg = "";
    if (isset($_GET['verification'])) {
        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE code='{$_GET['verification']}'")) > 0) {
            $query = mysqli_query($conn, "UPDATE users SET code='' WHERE code='{$_GET['verification']}'");
            
            if ($query) {
                $msg = "<div style='color:green; text-align:center; margin:0 auto; font-size: 15px;'>Account succesfully verified. Login Now!</div>";
            }
        } else {
            header("Location: index.php");
        }
    }

    if (isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['pass']);

        $sql = "SELECT * FROM users WHERE email='{$email}' AND password ='{$password}'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if (empty($row['code'])) {
                $_SESSION['SESSION_EMAIL'] = $email;
                header("Location: home.php");
            } else {
                $msg = "<div style='color:red; text-align:center; margin:0 auto; font-size: 15px;'>Verification failed. Try again.</div>";
            }
        } else {
            $msg = "<div style='color:red; text-align:center; margin:0 auto; font-size: 15px;'>Email and password doesn't match.</div>";
        }
    }
    if (isset($_SESSION['message'])) {
        echo '<script type="text/javascript">alert("' . $_SESSION['message'] . '");</script>';
        unset($_SESSION['message']);
    }
?>
<?php
require_once('php/CreateDb.php');
require_once('./php/component.php');

$db = new CreateDb(dbname: "Productdb", tablename: "Producttb");

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset set="UTF-8">
<meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
<title>WishList - Login</title>
<link rel="stylesheet" href="style.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href = "https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="header">
<!-- Navigation -->
    <div class = "logo">
        <a href = "home.php"><img src="images/logo.png"  width="135px" href  = "home.php"></a>
    </div>
    <div class = "navitems">
            <form action="./search.php" method="get">
              <span class = "searchbox">
                <input type="text" name = "search" placeholder="Find exclusive deals!" maxlength="20" style="width: 180px;">
                <button type="submit" class = "magni"><i class="fa fa-search"></i></button>
              </span>
            </form> 
        <a href = "home.php" class="menuitems">Home</a>
        <a href = "products.php" class="menuitems">Our Products</a>
        <a style="color:white; cursor:default;" class="menuitems">Login</a>
        <a href = "register.php" class="menuitems">Register</a>
        <a href="about.php" class="menuitems">About Wishlist</a>
        <a href="cartpage.php" class="menuitems"><i class="fa fa-shopping-cart" style="font-size: 2em;" aria-hidden="true"></i></a>
        <?php
				if (isset($_SESSION['cart'])){
                            $count = count($_SESSION['cart']);
                            echo "<span id=\"cart_count\" class=\"text-warning bg-light\">$count</span>";
                        }else{
                            echo "<span id=\"cart_count\" class=\"text-warning bg-light\">0</span>";
                        }
		?>
        
    </div>
</div>
<div class="main">
    <div class="row">
        <div class="wishcont">
            <form method="post" action="#">
                <h1 class="title" style="text-align: center; color: black;">Login</h1>
                <?php echo $msg; ?>
                <div class="inpbox">
                    <h3>Email:</h3>
                    <input type="email" name="email" class="loginp" placeholder="Enter your Email" required>
                </div>
                <div class="inpbox">
                    <h3>Password:</h3>
                    <input type="password" name="pass" class="loginp" placeholder="Enter your Password" required>
                </div>
                <div class="login">
                        <button name="submit" class="logins"><span class="subm">Login</span></button>
                    <a href="register.php"><p class="sgnup">Don't have an Account? Sign Up Now!</p></a>
                </div>
               



            </form>
        </div>   
            
            
         
        </div>

    </div>
</div>

<!--Footer -->
<div class = "footer">
      <div class = "container">
        <div class = "row">
          <div class="col1">
            <img src = "images/logo-white.png">
          </div>
          <div class = ".col2">
            <h3>Guidelines</h3>
            <span><a href ="">Return & Privacy Policy</a></span><br>
            <span><a href="">Terms and Conditions</a></span>
            </div>
            <div class="v2"></div>
            <div class = ".col3">
              <h3>Contact Us</h3>
              <span><a href = "https://www.facebook.com/Wish-List-by-Danna-110507777772007">Facebook</a></span><br>
              <span><a href="mailto:wishlist.inquiries@gmail.com" target="_blank" class="social-gmail">Gmail</a></span><br>
            </div>
            <div class="v2"></div>
            <div class=".col4">
              <h3>Attributions</h3>
              <span><a href="https://www.vecteezy.com/free-vector/fashion-icon">Fashion Icon Vectors <br>
                by Vecteezy</a></span>
            
            </div>
        </div>
        <hr>
        <p class = "copyright">  © Wishlist 2022</p>
      </div>
      </div>        
    </div>




</body>
<script src="js/jquery.min.js"></script>

</html>