<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$connection = mysqli_connect("localhost", "root", "root", "360interiors");

if (mysqli_connect_error()) {
    die("Cannot connect database" . mysqli_connect_error());
}

Include "security.php";
$desID = null;
// Check if the designerID is set in the query string
if (isset($_GET['designerID'])) {
    
    $desID = $_GET['designerID'];
}
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>360 interiors</title>

        <!--to add the favicon-->
        <link rel="icon" type="image/png" href="img/logo_ver2-removebg-preview.png">
        <link rel="stylesheet" href="unifiedstyle.css">

        <link rel="stylesheet" href="clientStyle.css"/>
        <script src=".js"></script>
        <style>
            body {
                background-image: linear-gradient(180deg,
                    rgba(100, 100, 40, 0.9),
                    rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0)), url("img/consultation.jpg");

            }


        </style>
    </head>
    <body>
        <header>
            <h1>Request A Consultation</h1>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href='clientHomepage.php'>Client Homepage</a></li>
                <li class="breadcrumb-item"><a href='requestConsultation.php'>Consultation Request</a></li>

            </ul>
        </header>

        <form id="ConsultationForm" action="addRequest.php" method="POST">
            <!--   part a add hidden input-->
            <input type="hidden" name="designerID" value="<?php echo htmlspecialchars($desID); ?>">
            <label for="roomType">Room Type:</label><br>
            <select id="roomType" name="roomType">
                <option>Living Room</option>
                <option>Bedroom</option>
                <option>Kitchen</option>
                <option>Dining Room</option>
                <option>Guest Room</option>
            </select><br>

            <br><label>room dimensions(in meter):
                <br>width:<input type="text" name="width" value="">
                <br>length:<input type="text" name="length" value="">
            </label><br>


            <label for="DesignCatagory">Design category:</label>
            <select name="DesignCatagory" id="DesignCatagory">
                <option selected>Country</option>
                <option>Modern</option>
                <option>Coastal</option>
                <option>Minimalist</option>
                <option>Bohemian</option>
            </select>
            <br>
            <label>Color preferences: <input type="text" name="colorPreference" value=""></label>
            <br>
            <label>Date: <input type="date" name="date"></label>
            <br>
            <label for="ConsultationBox">Consultation:</label><br>
            <textarea id="ConsultationBox" name="ConsultationBox" placeholder="Write your consultation here" ></textarea>
            <br>
            <label for="img">Upload Image:</label><br>
            <input id="img" type="file" name="consultimg"><br>

            <br>

            <button id="sendConsultation" type="submit">Send</button>
        </form>

        <footer class="footer">
            <p>Email: <a href="mailto:contact@360interiors.com">contact@360interiors.com</a></p>
            <p>&copy; 2024 360Interiors. All rights reserved.</p>
            <a href="https://instagram.com/yourusername" target="_blank">Instagram</a>
            <a href="https://example.com/youraccount" target="_blank">X Account</a>
        </footer>
    </body>
</html>
