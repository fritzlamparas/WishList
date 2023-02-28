<?php
    session_start();
    include 'config.php';
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='{$_SESSION['SESSION_EMAIL']}'");
?>
<?php


require_once('php/CreateDb.php');
require_once('./php/component.php');

$db = new CreateDb(dbname: "Productdb", tablename: "Producttb");
?>
<!DOCTYPE html>
<html lang = "en">
<head>
  <meta charset set="UTF-8">  
  <meta name="viewport" content = "width=device-width, initial-scale=1">
  <title>Wishlist - About Us</title>
  <link rel="stylesheet" href = "style.css">
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
            <?php    if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            echo'<span><a href = "logout.php" class="menuitems" >Logout (' . $row['name'] .')</a></span>';
            }
            else{
            echo'<a href = "index.php" class="menuitems">Login</a>';
            echo'<a href = "register.php" class="menuitems">Register</a>';
            }
            ?>
            <a style="color:white; cursor:default;" class="menuitems">About Wishlist</a>
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
          <div class="wishcont" style="width:50%">
            <div class="abtcont">
              <h1 class="abttitle">Wishlist</h1>
              <p>is a small clothing business founded by Chryshyll Nava and Daryll Casalan which focuses on selling high quality branded clothing and fashion accessories.</p>
              <div class="hrdiv">
                <hr>
              </div>
              <h1 class="abttitle">Mission</h1 >
              <p>To provide the best service, experience and fashion products for people to keep up trends with an affordable price.</p>
              <div class="hrdiv">
                <hr>
              </div>
              <h1 class="abttitle">Vision</h1>
              <p>To become a well known and admired clothing retailer engaged in open stores globally treating everyone fairly and equally.</p>  
            </div>
          </div>
        </div>
    </div>


   <!--Footer-->
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
 
    
    <script src = "confirmout.js"></script>
</body>
</html>