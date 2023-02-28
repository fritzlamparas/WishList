<?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    session_start();
     // Create login database
     require_once('php/CreateDb.php');
     $database = new CreateLoginDb(dbname:"productdb", tablename:"users");
    if (isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: home.php");
        die();
    }

    //Load Composer's autoloader
    require 'vendor/autoload.php';

    include 'config.php';
    $msg = "";

    if (isset($_POST['submit'])) { 
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['pass']));
        $confirm_password = mysqli_real_escape_string($conn, md5($_POST['cpass']));
        $code = mysqli_real_escape_string($conn, md5(rand()));

        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
            $msg = "<div style='color:red; text-align:center; margin:0 auto; font-size: 15px;'>The email has already been used.</div>";
        } else {
            if ($password === $confirm_password) {
                $sql = "INSERT INTO users (name, email, password, code) VALUES ('{$name}', '{$email}', '{$password}', '{$code}')";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    echo "<div style='display: none;'>";
                    //Create an instance; passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Username   = 'dummymadwolf5@gmail.com';                     //SMTP username
                        $mail->Password   = 'madwolf312001pogi';                               //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                        //Recipients
                        $mail->setFrom('dummymadwolf5@gmail.com');
                        $mail->addAddress($email);

                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'no reply';
                        $mail->Body    = 'Here is the verification link <b><a href="http://localhost/WishList/?verification='.$code.'">http://localhost/Feb%2028/?verification='.$code.'</a></b>';
                        $mail->send();
                        echo 'Message has been sent';
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                    echo "</div>";
                    $msg = "<div style='color:green; text-align:center; margin:0 auto; font-size: 15px;'>We've sent a verification link to your email.</div>";
                } else {
                    $msg = "<div style='color:red; text-align:center; margin:0 auto; font-size: 15px;'>Something went wrong. Try again.</div>";
                }
            } else {
                $msg = "<div style='color:red; text-align:center; margin:0 auto; font-size: 15px;'>The passwords didn't match. Please try again.</div>";
            }
        }
    }
?>
<?php
require_once('./php/component.php');
$db = new CreateDb(dbname: "Productdb", tablename: "Producttb");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset set="UTF-8">
<meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
<title>WishList - Register</title>
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
        <a href = "home.php"><img src="images/logo.png"  width="135px"></a>
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
        <a href="index.php" class="menuitems">Login</a>
        <a style="color:white; cursor:default;" class="menuitems">Register</a>
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


            <form method="post" action="">
                <h1 class="title" style="text-align: center; color: black;">Register</h1>
                <?php echo $msg; ?>
                <div class="inpbox">
                    <h3>Name:</h3>
                    <input type="text" name="name" class="loginp" maxlength = "15" placeholder="Enter your Name" value="<?php if (isset($_POST['submit'])) {echo $name;}?>" required>
                </div>
                <div class="inpbox">
                    <h3>Email:</h3>
                    <input type="email" name="email" class="loginp" maxlength = "100" placeholder="Enter your Email" value="<?php if (isset($_POST['submit'])) {echo $email;}?>"  required>
                </div>
                <div class="inpbox">
                    <h3>Password:</h3>
                    <input type="password" name="pass" class="loginp" maxlength = "25" placeholder="Enter your Password" required>
                </div>
                <div class="inpbox">
                    <h3>Confirm Password:</h3>
                    <input type="password" name="cpass" class="loginp" placeholder="Confirm Password" required>
                </div>
                <div class="login">
                    <button name="submit" class="logins"><span class="subm">Register</span></button>
                    <a href="index.php"><p class="sgnup">Already have an Account? Sign In Now!</p></a>
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
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript"></script>
</html>