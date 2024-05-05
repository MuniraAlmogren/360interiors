<?php
session_start();

if(!isset($_SESSION["userId"])){
//redirect the user to the home page

header("Location: sign.php");
}
?>