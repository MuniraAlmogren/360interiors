<?php

include "security.php";
$conn = mysqli_connect('localhost', 'root', 'root', '360interiors');
if (mysqli_connect_error()) {
    exit(mysqli_error($conn));
}
//part b
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $requestID = $_POST['requestID'];
    $consultationText = $_POST['myTextarea'];
    $consultationImgFileName = $_FILES['fileInput']['name'];
    //file path
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/360interiors/';
    $targetPath = $uploadDir . basename($consultationImgFileName);
    move_uploaded_file($_FILES['fileInput']['tmp_name'], $targetPath);

    // Find the ID for "consultation provided"
    $statusQuery = "SELECT id FROM RequestStatus WHERE status = 'consultation provided'";
    $statusResult = mysqli_query($conn, $statusQuery);
    $statusRow = mysqli_fetch_assoc($statusResult);
    $statusProvidedId = $statusRow['id'];

    // Update request status
    $updateQuery = "UPDATE DesignConsultationRequest SET statusID = {$statusProvidedId} WHERE id = {$requestID}";
    mysqli_query($conn, $updateQuery);

    //insert new consultaion 
    $insertquery = "INSERT INTO DesignConsultation (requestID, consultation, consultationImgFileName) VALUES ('$requestID', '$consultationText', '$consultationImgFileName')";
    mysqli_query($conn, $insertquery);
    // Redirect to the designer's homepage
    header("Location: DesignerHomePage.php");
    exit();
}
?>