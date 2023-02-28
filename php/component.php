<?php
function component($productname, $productprice, $productimg, $productid){ 
	$element = "
	
	<div class = \"prodcol\" onclick=\"\">
	<form action=\"\" method=\"post\">

					<img src = \"$productimg\">
				
					<h6>$productname</h6>
					<p>₱$productprice</p>
					<input type=\"submit\" value=\"Add to Cart\" style=\"cursor:pointer; background-color:whitesmoke; color:black; text-decoration:underline; border:none; font-size: 15px;\" name=\"add\"></input>
					<input type='hidden' name='product_id' value='$productid'>
					</form>
	</div>
	";
	echo $element;
}

function cartElement($productimg,$productname,$productprice, $productid){
	$element = "
		<form action=\"cartpage.php?action=remove&id=$productid\" method=\"post\" class=\"cart-items\">
		<tr class = \"cartcol\">
                <td>
                    <img src = \"$productimg\">
                    <div class=\"cartt\">
                        <p>$productname</p>
                        <small style=\"margin-bottom:1px;\">$$productprice</small>
                        <br>
                        <button type=\"submit\" style=\"cursor:pointer; background-color:whitesmoke; color:black; text-decoration:underline; border:none; font-size: 15px; padding:10px 0;\" name=\"remove\">Remove</button>
                    </div>
                </td>
                <td><input type=\"number\" value=\"1\" min=\"1\"></td>
                <td>$$productprice</td>
            </tr>
		</form>
	";
	echo $element;
} 
?>
