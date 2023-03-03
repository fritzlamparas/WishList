<!-- For Displaying Login/Register or Logout -->
<?php
    session_start();
    include 'config.php';
    require_once('php/CreateDb.php');
    require_once('./php/component.php');

//create instance of Createdb class
    $database = new CreateDb(dbname:"Productdb", tablename:"Producttb");
    $database = new CreateLoginDb(dbname:"login", tablename:"users");
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='{$_SESSION['SESSION_EMAIL']}'");
?>
<!-- AddtoCart with Login Checking-->
<?php
require_once('php/CreateDb.php');
require_once('./php/component.php');

//create instance of Createdb class
$database = new CreateDb(dbname:"Productdb", tablename:"Producttb");
if(isset($_POST['add'])){
  if (!isset($_SESSION['SESSION_EMAIL'])) {
    $_SESSION['message'] = "You need to login on an account first.";
    header("Location: index.php");
    die();
}
else{
	if(isset($_SESSION['cart'])){
		$item_array_id = array_column($_SESSION['cart'], "product_id");

		
		if(in_array($_POST['product_id'],$item_array_id)){

		}else{
			
			$count = count($_SESSION['cart']);
            $item_array = array(
                'product_id' => $_POST['product_id']
            );

            $_SESSION['cart'][$count] = $item_array;
		}
		
	}else {
		
		$item_array = array(
			'product_id' => $_POST['product_id']
		
		);
		
		//Create new session variable
		$_SESSION['cart'][0] = $item_array;

	}
}
}
?>
<!DOCTYPE html>
<html lang = "en">
<head>
  <meta charset set="UTF-8">  
  <meta name="viewport" content = "width=device-width, initial-scale=1">
  <title>WishList - Home </title>
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
          <a style="color:white; cursor:default;" class="menuitems">Home</a>
          <a href = "products.php" class="menuitems">Our Products</a>         
          <?php    if (mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            echo'<span><a href = "logout.php" class="menuitems">Logout (' . $row['name'] .')</a></span>';
            }
            else{
            echo'<a href = "index.php" class="menuitems">Login</a>';
            echo'<a href = "register.php" class="menuitems">Register</a>';
            }
          ?>
          
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

          <div class="maincol">
             
              <!-- Slideshow -->
              <div class="slideshow-container">

                <!-- Full-width images with number and caption text -->
                <div class="mySlides fade">
                  <div class="numbertext"></div>
                  <img src="images/categ1.png" style="width:100%">

                </div>
              
                <div class="mySlides fade">
                  <div class="numbertext"></div>
                  <img src="images/categ2.png" style="width:100%">
      
                </div>
              
                <div class="mySlides fade">
                  <div class="numbertext"></div>
                  <img src="images/categ3.png" style="width:100%">
                </div>
                <!-- Next and previous buttons -->
                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
              </div>
              <br>          
            <!-- Categories -->
            <div class="small-container">
              <h2 class = "title"> Categories</h2>  
              <div class="categ">
                
                <form action="./search.php" method="get">
                <span class = "searchbox">
                  <input type="text" name ="search" value="Accessories" style="display:none;">
                  <button type="submit" class ="categbox"><img src = "images/accessories.png"><span>Accessories</span></button>
                </span>
                </form> 
                <form action="./search.php" method="get">
                <span class = "searchbox">
                  <input type="text" name = "search" value="Bags" style="display:none;">
                  <button type="submit" class ="categbox"><img src = "images/bags.png"><span>Bags</span></button>
                </span>
                </form> 
                <form action="./search.php" method="get">
                <span class = "searchbox">
                  <input type="text" name = "search" value="Cosmetics" style="display:none;">
                  <button type="submit" class ="categbox"><img src = "images/cosmetics.png"><span>Cosmetics</span></button>
                </span>
                </form>     
                <form action="./search.php" method="get">
                <span class = "searchbox">
                  <input type="text" name = "search" value="Shoes" style="display:none;">
                  <button type="submit" class ="categbox"><img src = "images/footwear.png"><span>Shoes</span></button>
                </span>
                </form>                    
                <form action="./search.php" method="get">
                <span class = "searchbox">
                  <input type="text" name = "search" value="Headwear" style="display:none;">
                  <button type="submit" class ="categbox"><img src = "images/headwear.png"><span>Headwear</span></button>
                </span>
                </form> 

              </div>
            </div>
          <!-- Latest Products-->
          <div class="small-container">
            <h2 class = "title"> Latest Products </h2>
            <div class = "row">
            <!-- Getting Products -->
            <?php
            $result = $database->getData();
            $a = 0;
            while ($row= mysqli_fetch_assoc($result)){
               
                $productname = $row['product_name'];
                $productprice = $row['product_price'];
                $productimg =  $row['product_image'];
                $productid =  $row['id'];

                echo <<< END
                <div class = "prodcol" onclick="Redirect('$productid')">
                <form action="" method="post">
                        <img src = "$productimg">                
                        <h6>$productname</h6>
                        <p>₱$productprice</p>
                        <input type="submit" value="Add to Cart" class="add2c" name="add"></input>
                        <input type='hidden' name='product_id' value='$productid'>
                        </form>
                </div>
                END;
                if ($a > 12) {
                  break;
                }
                $a = $a + 1;
              }              		
            ?>                             
            </div>
          </div>
          <!-- Brands -->    
          <div class = "small-container">
              <h2 class = "title" style="text-align: center;"> Featured Brands</h2>
              <div class = "row">
                <form action="./search.php" method="get">
                <span class = "searchbox">
                  <input type="text" name = "search" value="Onitsuka Tiger" style="display:none;">
                  <button type="submit" class ="br" style="border:none;"><img src = "images/logo-onitsuka.png" style="background-color:whitesmoke;"></button>
                </span>
                </form>
                <form action="./search.php" method="get">
                <span class = "searchbox">
                  <input type="text" name = "search" value="Sally Hansen" style="display:none;">
                  <button type="submit" class ="br" style="border:none;"><img src = "images/logo-sallyhansen.png" style="background-color:whitesmoke;"></button>
                </span>
                </form> 
                <form action="./search.php" method="get">
                <span class = "searchbox">
                  <input type="text" name = "search" value="Sperry" style="display:none;">
                  <button type="submit" class ="br" style="border:none;"><img src = "images/logo-sperry.png" style="background-color:whitesmoke;"></button>
                </span>
                </form> 
                <form action="./search.php" method="get">
                <span class = "searchbox">
                  <input type="text" name = "search" value="Michael Kors" style="display:none;">
                  <button type="submit" class ="br" style="border:none;"><img src = "images/logo-michaelkors.png" style="background-color:whitesmoke;"></button>
                </span>
                </form> 
                <form action="./search.php" method="get">
                <span class = "searchbox">
                  <input type="text" name = "search" value="Converse" style="display:none; ">
                  <button type="submit" class ="br" style="border:none; background-color:none; color:none;"><img src = "images/logo-converse.png" style="background-color:whitesmoke;"></button>
                </span>
                </form>     
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

    <script>
      function Redirect(id){
        window.location.href = "product_detail.php?productid="+id;
        
      }
    </script>
    <script src = "slideshow.js"></script>

</body>
</html>