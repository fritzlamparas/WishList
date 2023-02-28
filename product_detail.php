<!-- For Displaying Login/Register or Logout -->
<?php
    session_start();
    include 'config.php';
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='{$_SESSION['SESSION_EMAIL']}'");
?>
<!-- AddtoCart with Login Checking-->
<?php
require_once('php/CreateDb.php');
require_once('./php/component.php');


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
<html lang="en">
<head>
<meta charset set="UTF-8">
<meta name = "viewport" content = "width = device-width, initial-scale = 1.0">
<title>WishList - Details</title>
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
<!-- Product Details-->
<div class="main2">
    <div class="small-container prod-deta">
        <div class = "row">
            <?php
                 if (isset($_GET["productid"])){

                     $detailid = $_GET["productid"];
                     $conne = mysqli_connect("localhost", "root", "", "productdb");
                     $query = mysqli_query($conne, "SELECT * FROM producttb WHERE id = '$detailid'");
                     while ($row= mysqli_fetch_assoc($query)){
               
                        $productname = $row['product_name'];
                        $productprice = $row['product_price'];
                        $productimg =  $row['product_image'];
                        $productid =  $row['id'];
                 }
                 echo <<< END
                 <div class = "detcol">
                    <img src = "$productimg" id ="big">
                 </div> 
                 <div class="detcol">
                    <h1>$productname</h1>
                    <h4>₱$productprice</h4> 
                    <h3>Product Details</h3>
                    <p style="text-align: justify;">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa fugit, est assumenda iure saepe sint, perspiciatis suscipit expedita, obcaecati fuga velit eveniet? Illo natus quisquam laborum reiciendis, maiores ipsam asperiores!</p>                     
                    <form action="" method="post">
                    <center>
                    <input type="submit" value="Add to Cart" class = "add2c" name="add"></input>
                    </center>
                    </form>
                 </div>
                 END ;
                }
             ?>

        </div>
    </div>
<!--title-->
    <div class="small-container">
        
        <h2 class ="reltitle"> Relevant Products</h2>
 
    </div>
    <div class = "small-container">
        <div class = "row">
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
                        <input type="submit" value="Add to Cart" class ="add2c" name="add"></input>
                        <input type='hidden' name='product_id' value='$productid'>
                        </form>
                </div>
                END;
                if ($a > 3) {
                  break;
                }
                $a = $a++;
              }              		
            ?>           
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


</body>
<script>
      function Redirect(id){
        window.location.href = "product_detail.php?productid="+id;
        
      }
</script>
</html>