<!-- Login Checking before entering -->
<?php
    session_start();
    if (!isset($_SESSION['SESSION_EMAIL'])) {
        $_SESSION['message'] = "You need to login on an account first.";
        header("Location: index.php");
        die();
    }
    include 'config.php';
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='{$_SESSION['SESSION_EMAIL']}'");

?>
<!-- Removing Cart Items-->
<?php


require_once('php/CreateDb.php');
require_once('./php/component.php');

$db = new CreateDb(dbname: "Productdb", tablename: "Producttb");

if (isset($_POST['remove'])){
  if ($_GET['action'] == 'remove'){
      foreach ($_SESSION['cart'] as $key => $value){
          if($value["product_id"] == $_GET['id']){
              unset($_SESSION['cart'][$key]);
              echo "<script>window.location = 'cartpage.php'</script>";
          }
      }
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset set="UTF-8">
<meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
<title>WishList - My Cart</title>
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
        <?php    if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            echo'<span><a href = "logout.php" class="menuitems" >Logout (' . $row['name'] .')</a></span>';
            }
            else{
            echo'<a href = "index.php" class="menuitems">Login</a>';
            echo'<a href = "register.php" class="menuitems">Register</a>';
            }
        ?>
        <a href="about.php" class="menuitems">About Wishlist</a>
        <a style="color:white; cursor:default;" class="menuitems"><i class="fa fa-shopping-cart" style="font-size: 2em;" aria-hidden="true"></i></a>
        <?php
            if (isset($_SESSION['cart'])){
                                $count = count($_SESSION['cart']);
                                echo "<span id=\"cart_count\" class=\"text-warning bg-light\" style=\"color:white;\">$count</span>";
                            }else{
                                echo "<span id=\"cart_count\" class=\"text-warning bg-light\" style=\"color:white;\">0</span>";
                            }
        ?>
    </div>
</div>
<div class="main">
    <div class="small-container cartp">
        <table>
        <tr>
                <th>Product Details</th>
                <th>Quantity</th>
                <th>Subtotal</th>
        </tr>
        <!-- Cart Items Display-->
		<?php
			$total = 0;
                    if (isset($_SESSION['cart'])){
                        $product_id = array_column($_SESSION['cart'], 'product_id');

                        $result = $db->getData();
                        while ($row = mysqli_fetch_assoc($result)){
                            foreach ($product_id as $id){
                                if ($row['id'] == $id){
                                    cartElement($row['product_image'], $row['product_name'],$row['product_price'], $row['id']);
                                    $total = $total + (int)$row['product_price'];
                                }
                            }
                        }
                    }else{
                        echo "<h5>Cart is Empty</h5>";
                    }
		?>
        </table>
        <div class="col-md-4 offset-md-1 border rounded mt-5 bg-white h-25">
			<div class="pt-4">
			<h5>PRICE DETAILS</h5>
			<hr>
			<div class="row price-details">
				<div class="col-md-6">
                    <!-- Total Price Display-->
					<?php
						if (isset($_SESSION['cart'])){
									$count  = count($_SESSION['cart']);
									echo "<h5>Price ($count items)</h5>";
								}else{
									echo "<h5>Price (0 items)</h5>";
								}
					?>
					<h5>Delivery Charges</h5>
					<hr>
					<h5>Amount Payable</h5>
				</div>
					<div class="col-md-6">
                        <h5>$<?php echo $total; ?></h5>
                        <h5 class="text-success">FREE</h5>
						<hr>
                        <h5>$<?php
                            echo $total;
                            ?></h5>
                    </div>
					</div>
				</div>
			</div>    
         
    </div>
</div>
<!--footer -->
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
<script src="confirmout.js"></script>
</body>
</html>