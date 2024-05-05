<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to the homepage
header("Location: sign.php"); // Adjust the path to your homepage as necessary
exit();

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

