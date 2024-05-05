<?php
session_start();
include 'security.php';

$connection = mysqli_connect("localhost", "root", "root", "360interiors");

if (!$connection) {
    echo json_encode(false);
    exit;
}

// Retrieve consultation ID from AJAX request
$request_id = isset($_POST['request_id']) ? intval($_POST['request_id']) : 0;

// Update query
$query = "UPDATE designconsultationrequest SET statusID = (SELECT id FROM requeststatus WHERE status = 'consultation declined') WHERE id = ?";
$stmt = mysqli_prepare($connection, $query);

// Error handling and execution
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'i', $request_id);
    $execute = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo json_encode($execute);
} else {
    echo json_encode(false);
}
?>
