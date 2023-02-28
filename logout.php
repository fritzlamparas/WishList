<?php

session_start();
unset($_SESSION['SESSION_EMAIL']);
header("Location: index.php");
?>