<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include "security.php";

$conn = mysqli_connect('localhost', 'root', 'root', '360interiors');
if (mysqli_connect_error()) {
    exit(mysqli_error($conn));
}

//part a : check req ID , retrieve
if (isset($_GET['request_id'])) {
    $requestID = $_GET['request_id'];

    $queryRetrieveInfo = "SELECT 
        c.firstName AS clientFirstName, 
        c.lastName AS clientLastName, 
        r.type AS roomType, 
        dc.category AS designCategory, 
        d.roomWidth, 
        d.roomLength, 
        d.colorPreferences, 
        d.date
    FROM 
        designconsultationrequest d
        INNER JOIN client c ON d.clientID = c.id
        INNER JOIN roomtype r ON d.roomTypeID = r.id
        INNER JOIN designcategory dc ON d.designCategoryID = dc.id
    WHERE 
        d.id = $requestID";

    $resultInfo = mysqli_query($conn, $queryRetrieveInfo);

    if ($resultInfo && mysqli_num_rows($resultInfo) > 0) {
        $request = mysqli_fetch_assoc($resultInfo);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Designer Consultation Page</title>
        <link rel="stylesheet" href="unifiedstyle.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="img/logo_ver2-removebg-preview.png">
        <link rel="stylesheet" href="designerStyle.css">
        <style>
            body {
                background-image: linear-gradient(180deg, rgba(100,100 , 40, 0.9), rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0)), url("img/consultation.jpg");
            }
            .change2 {
                color: rgb(173,174,176);
            }
        </style>
    </head>
    <body>
        <h1>Designer Consultation Page</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item"><a href="DesignerHomePage.php">Designer Home Page</a></li>
            <li class="breadcrumb-item"><a href="DesignConsultation.php">Consultation</a></li>
        </ul>
        <label class="change2">Request Information</label>
        <div class="box">
            <?php
            if ($resultInfo && mysqli_num_rows($resultInfo) > 0) {
                echo "Client: " . $request['clientFirstName'] . " " . $request['clientLastName'] . "<br>";
                echo "Room: " . $request['roomType'] . "<br>";
                echo "Dimensions: " . $request['roomWidth'] . "x" . $request['roomLength'] . " m<br>";
                echo "Design Category: " . $request['designCategory'] . "<br>";
                echo "Color Preferences: " . $request['colorPreferences'] . "<br>";
                echo "Date: " . $request['date'] . "<br>";
            }
            ?>
        </div>
        <label class="change2">Consultation:</label>
        <form action="process_consultation.php" method="post" enctype="multipart/form-data">
            <textarea  name="myTextarea" rows="4" cols="50"></textarea><br>
            <input type="hidden" name="requestID" value="<?php echo $requestID; ?>">
            <label class="change2">Upload Image:</label><br>
            <input type="file" name="fileInput" ><br>
            <div class="button-container">
                <input type="submit" value="Send"><br>
            </div>
        </form>
        <footer class="footer">
            <p>Email: <a href="mailto:contact@360interiors.com">contact@360interiors.com</a></p>
            <p>&copy; 2024 360Interiors. All rights reserved.</p>
            <a href="https://instagram.com/yourusername" target="_blank">Instagram</a>
            <a href="https://example.com/youraccount" target="_blank">X Account</a>
        </footer>
    </body>
</html>
