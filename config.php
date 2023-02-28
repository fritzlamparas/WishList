<?php
// Access the Database
$conn = mysqli_connect("localhost", "root", "", "productdb");
if (!$conn) {
    echo "Connection Failed";
}
?>