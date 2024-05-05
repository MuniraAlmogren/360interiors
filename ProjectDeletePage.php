<?php
// Include necessary files and initialize session if needed
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include 'security.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['project_id'])) {
    // Get the project ID from the POST data
    $project_id = $_POST['project_id'];
    
    // Include database connection if necessary
    $connection = mysqli_connect("localhost", "root", "", "360interiors");
    
    // Check if the connection is successful
    if (mysqli_connect_error()) {
        die("Cannot connect to database: " . mysqli_connect_error());
    }

    // Get designer ID from session
    $designer_id = $_SESSION['userId'];

    // Prepare and execute the delete query
    $query = "DELETE FROM designportfolioproject WHERE id = $project_id AND designerID = $designer_id";
    $result = mysqli_query($connection, $query);

    // Check if the delete operation was successful
    if ($result && mysqli_affected_rows($connection) > 0) {
        // Return true if successful
        echo 'true';
        exit();
    } else {
        // Return false if unsuccessful
        echo 'false';
        exit();
    }
} else {
    // Return false if project ID is not provided
    echo 'false';
    exit();
}
?>

