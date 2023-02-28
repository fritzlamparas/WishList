<!-- AddtoCart with Login Checking-->
<?php
session_start();
include 'config.php';

$query = mysqli_query($conn, "SELECT * FROM users WHERE email='{$_SESSION['SESSION_EMAIL']}'");
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
  <title>WishList</title>
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
            <?php    
              if (mysqli_num_rows($query) > 0) {
              $row = mysqli_fetch_assoc($query);
              echo'<span><a href = "logout.php" class="menuitems" >Logout (' . $row['name'] .')</a></span>';
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
          <div class="small-container">
            <h2 class = "prodtitle"> Showing Results for: <?php echo ucwords($_GET['search']); ?> </h2>
            <!--
            <select>
              <option> --- </option>
              <option> Highest Sales </option>
              <option> Highest Ratings </option>
              <option> Highest Prices </option>
              <option> Lowest Prices </option>
            </select> -->
            <div class = "row">
            <!-- Provided Keyword Checker -->          
            <?php
              $k = $_GET['search'];
              include './include.php';
              if($k != ''){
                  $k = ucwords($k);
                  $search = trim($k);
                  $a = 0;
                  $query_string = "SELECT * FROM  producttb WHERE ";
                  $keywords = explode(' ',$search);
                
                  foreach($keywords as $word){
                  $query_string .= " product_name LIKE '%".$word."%' OR ";
                  }
                  $query_string = substr($query_string, 0, strlen($query_string) - 3);

                  $conn = mysqli_connect("localhost","root","","productdb");
                  if (!$conn) {
                    echo "Connection Failed";
                  }
                  $query = mysqli_query($conn, $query_string);
                  $result_count = mysqli_num_rows($query);

                  if($result_count > 0){
                    while ($row = mysqli_fetch_assoc($query)){
                      component($row['product_name'], $row['product_price'], $row['product_image'], $row['id']);
                      if ($a > 8) {
                        break;
                      }
                      $a++;
                    }
                  }
                  else{
                    echo "<center><h1>No results found.</h1></center>";
                  }
                  
              }
              else{
                  echo "<center><h1>No keywords entered.</h1></center>";
              }
            ?>
            </div>
            <div class = "PageBtn" style="display:none;">
              <span> 1 </span>
              <span> 2 </span>
              <span> 3 </span>
              <span> 4 </span>	
              <span> &#x2794;</span>
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
 
    
    <script src="confirmout.js"></script>
</body>
</html>