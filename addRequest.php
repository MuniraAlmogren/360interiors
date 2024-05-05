<?php
include "security.php";
$conn = mysqli_connect('localhost', 'root', 'root', '360interiors');
if (mysqli_connect_error()) {
    exit(mysqli_connect_error());
}

$clientID = $_SESSION['userId'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $roomType = $_POST['roomType'];
    $width = $_POST['width'];
    $length = $_POST['length'];
    $designCategory = $_POST['DesignCatagory'];
    $colorPreference = $_POST['colorPreference'];
    $date = $_POST['date'];
    $consultation = $_POST['ConsultationBox'];
    $designerID = $_POST['designerID'];
    
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';

    // Handle file upload
    if (isset($_FILES['consultimg']) && $_FILES['consultimg']['error'] == 0) {
        $extension = pathinfo($_FILES['consultimg']['name'], PATHINFO_EXTENSION);
        $fileName = time() . '_' . $designerID . '.' . $extension; 

        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['consultimg']['tmp_name'], $targetPath)) {
            
            echo "<script>alert('The file has been uploaded successfully.');</script>";

            // Store the file name in the database
            $filePath = mysqli_real_escape_string($conn, $fileName);

        } else {
            // Error occurred during file upload
            echo "<script>alert('There was an error uploading the file.');</script>";
        }
    } 
    
    $sql= " SELECT id FROM RequestStatus WHERE status='pending consultation'";
    $result= mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $statusID = $row['id'];
   
    $sqlIDS = "SELECT rt.id AS roomTypeId, dc.id AS designCategoryId
        FROM RoomType rt
        INNER JOIN DesignCategory dc ON rt.type = '$roomType' AND dc.category = '$designCategory'";
    $resultIDS = mysqli_query($conn, $sqlIDS);

    if ($resultIDS && mysqli_num_rows($resultIDS) > 0) {
        $rowIDS = mysqli_fetch_assoc($resultIDS);
        $roomTypeId = $rowIDS['roomTypeId'];
        $designCategoryId = $rowIDS['designCategoryId'];
    }
    // Add the new request to the database 
    $query = "INSERT INTO DesignConsultationRequest (clientID, designerID, roomTypeID, designCategoryID, roomWidth, roomLength, colorPreferences, date, statusID)
              VALUES ('$clientID', '$designerID', '$roomTypeId', '$designCategoryId', '$width', '$length', '$colorPreference', '$date', '$statusID')";


    if (mysqli_query($conn, $query)) {
        // Redirect to the client's homepage
        header("Location: clientHomepage.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
