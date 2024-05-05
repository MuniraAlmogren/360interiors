<?php
//session
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

// message for user when eamil exists
if (isset($_GET['error']) && $_GET['error'] === 'emailExists') {
    echo '<script>alert("The email address you entered already exists. Please use a different email.");</script>';
}


//connect to DB
$conn = mysqli_connect('localhost', 'root', 'root', '360interiors');
//check connection error
if (mysqli_connect_error()) {
    echo 'failed to connect to the database';
    exit(mysqli_error());
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $usertype = $_POST['usertype'];
    //common fields
    $fname = $_POST['first-name'];
    $lname = $_POST['last-name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if ($usertype == 'designer') {



        $sql = "SELECT emailAddress FROM designer WHERE emailAddress = '$email'";
        $result = mysqli_query($conn, $sql);
        // Check if any rows are returned
        if (mysqli_num_rows($result) > 0) {
            // Email exists, redirect back with an error message(GET)
            header('Location: sign.php?error=emailExists');
            exit();
        } else {
            $brandname = $_POST['brand-name'];
            $logoName = $_FILES['logo']['name'];
            $specialty = $_POST['specialty'];   

            if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
                $uploadDir = "uploads/"; // Target directory
                $fileName = basename($_FILES['logo']['name']); 
                $targetPath = $uploadDir . time() . '_' . $fileName; 

                if (move_uploaded_file($_FILES['logo']['tmp_name'], $targetPath)) {
                    // If file uploaded successfully, show a message or redirect
                    echo "<script>alert('The file has been uploaded successfully.');</script>";
                    $filePath = mysqli_real_escape_string($conn, $targetPath);

                    //1.add the designer to DB
                    $sqladd_designer = "INSERT INTO Designer (firstName, lastName, emailAddress, password, brandName,logoImgFileName) VALUES ('$fname', '$lname', '$email', '$password', '$brandname','$filePath')";
                    mysqli_query($conn, $sqladd_designer);
                } else {
                    // If an error occurred during the upload, show an alert
                    echo "<script>alert('There was an error uploading the file.');</script>";
                }
            } else {
                // If no file was selected or an error occurred, show an alert
                echo "<script>alert('No file was uploaded or an error occurred.');</script>";
            }


            //get the designer's ID from DB
            $sqlgetdesignerID = "SELECT id FROM designer WHERE emailAddress='$email'";
            $sqlgetdesignerID_Q = mysqli_query($conn, $sqlgetdesignerID);
            $designerID = mysqli_fetch_assoc($sqlgetdesignerID_Q);
            $designerID = $designerID['id'];
            //based on designer's specialty insert into designerspecialty table
            foreach ($specialty as $sp) {
                $sqlgetcategoryID = "SELECT id FROM `designcategory` WHERE category='$sp'";
                $categoryIDresult = mysqli_query($conn, $sqlgetcategoryID);
                $categoryID = mysqli_fetch_assoc($categoryIDresult);
                $categoryID = $categoryID['id'];
                $sqlinsertspecialty = "INSERT INTO designerspeciality(`designerID`, `designCategoryID`) VALUES ($designerID,$categoryID)";
                mysqli_query($conn, $sqlinsertspecialty);
            }
            // designer id and type as session variables
            $_SESSION['userId'] = $designerID;
            $_SESSION['userType'] = 'designer';
        }
    }

    //--------------CLIENT-----------------------
    if ($usertype == 'client') {

        $sqlclientemail = "SELECT emailAddress FROM client WHERE emailAddress = '$email'";
        $result2 = mysqli_query($conn, $sqlclientemail);
        // Check if any rows are returned
        if (mysqli_num_rows($result2) > 0) {
            // Email exists, redirect back with an error message(GET)
            header('Location:sign.php?error=emailExists');
            exit();
        }


        $sqlinsertclient = "INSERT INTO client( `firstName`, `lastName`, `emailAddress`, `password`) VALUES ('$fname','$lname','$email','$password')";
        mysqli_query($conn, $sqlinsertclient);

        $sqlgetclientid = "SELECT id FROM client WHERE emailAddress='$email'";

        $getclientid = mysqli_query($conn, $sqlgetclientid);
        $clientid = mysqli_fetch_assoc($getclientid);
        $clientid = $clientid['id'];

        // client id and type as session variables
        $_SESSION['userId'] = $clientid;
        $_SESSION['userType'] = 'client';
    }

    if ($_SESSION['userType'] == 'designer') {
        // Redirect to designer homepage
        header('Location: DesignerHomePage.php');
    } else if ($_SESSION['userType'] == 'client') {
        // Redirect to designer homepage
        header('Location: clientHomepage.php');
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sign up</title>
        <link rel="stylesheet" href="sign.css">
        <!--to add the favicon-->
        <link rel="icon" type="image/png" href="img/logo_ver2-removebg-preview.png">
    </head>
    <body>
        <div class="container">
            <header>
                <a href="index.html">
                    <div class="logo-container">
                        <img src="img/logo_ver2-removebg-preview.png" alt="Logo" class="logo">
                    </div>
                </a>
            </header>


            <div class="content-container">
                <div class="form-container">
                    <h1>Welcome to 360 interiors!</h1>
                    <div class="wrapper">
                        <input type="radio" name="select" id="d-option-1" >
                        <input type="radio" name="select" id="c-option-2">
                        <label for="d-option-1" class="option option-1">
                            <span>Designer</span>
                        </label>
                        <label for="c-option-2" class="option option-2">
                            <span>Client</span>
                        </label>
                    </div>
                    <div id="form-container">
                        <form action="sign.php" id="designer-form" class="hidden" method="post" enctype="multipart/form-data" >
                            <div class="name-container">
                                <div class="name-field">
                                    <label for="first-name">First Name:</label>
                                    <input type="text" id="first-name" name="first-name" required>
                                </div>
                                <div class="name-field">
                                    <label for="last-name">Last Name:</label>
                                    <input type="text" id="last-name" name="last-name" required>
                                </div>
                            </div>
                            <label for="email">Email Address:</label>
                            <input type="email" id="email" name="email" required>

                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" required>
                            <hr>
                            <label for="brand-name">Brand Name:</label>
                            <input type="text" id="brand-name" name="brand-name" required>

                            <label for="logo">Logo:</label>
                            <input type="file" id="logo" name="logo" accept="image/*" required>

                            <label for="specialty"><br></br>Specialty:</label>
                            <div id="specialty">
                                <input type="checkbox" id="specialty-modern" name="specialty[]" value="Modern">
                                <label for="specialty-modern">Modern</label>

                                <input type="checkbox" id="specialty-country" name="specialty[]" value="Country">
                                <label for="specialty-country">Country</label>

                                <input type="checkbox" id="specialty-coastal" name="specialty[]" value="Coastal">
                                <label for="specialty-coastal">Coastal</label>

                                <input type="checkbox" id="specialty-bohemian" name="specialty[]" value="Bohemian">
                                <label for="specialty-bohemian">Bohemian</label>

                                <input type="checkbox" id="specialty-minimalist" name="specialty[]" value="Minimalist">
                                <label for="specialty-minimalist">Minimalist</label>
                                <input type="hidden" name="usertype" value="designer">

                            </div>
                            <button type="submit">Submit</button>
                            <p class="signup-link">One Of Us? <a href="login.php"> Log In</a></p>

                        </form>
                        <form action="sign.php" id="client-form" class="hidden" method="post" enctype="multipart/form-data">

                            <div class="name-container">
                                <div class="name-field">
                                    <label for="client-first-name">First Name:</label>
                                    <input type="text" id="client-first-name" name="first-name" required>
                                </div>
                                <div class="name-field">
                                    <label for="client-last-name">Last Name:</label>
                                    <input type="text" id="client-last-name" name="last-name" required>
                                </div>
                            </div>
                            <label for="c-email">Email Address:</label>
                            <input type="email" id="c-email" name="email" required>

                            <label for="c-password">Password:</label>
                            <input type="password" id="c-password" name="password" required>
                            <hr>
                            <input type="hidden" name="usertype" value="client">
                            <button type="submit">Submit</button>
                            <p class="signup-link">One Of Us? <a href="login.php"> Log In</a></p>

                        </form>
                    </div>

                </div>
            </div>


            <div class="image-container">
                <div class="img-box"></div>
                <img src="img/signin-crop.jpg" alt="Your Image">
            </div>
        </div>




    </body>

    <script>

        const option1 = document.querySelector('.option-1');
        const option2 = document.querySelector('.option-2');


        const designerOption = document.getElementById('d-option-1');
        const clientOption = document.getElementById('c-option-2');


        option1.addEventListener('click', handleDesignerOptionClick);
        option2.addEventListener('click', handleClientOptionClick);

        const designerForm = document.getElementById('designer-form');
        const clientForm = document.getElementById('client-form');


        designerOption.addEventListener('click', showDesignerForm);
        clientOption.addEventListener('click', showClientForm);

        // Function to show the designer form
        function showDesignerForm() {
            designerForm.style.display = 'block';
            clientForm.style.display = 'none';
        }

        // Function to show the client form
        function showClientForm() {
            clientForm.style.display = 'block';
            designerForm.style.display = 'none';
        }

        // Function to handle option button click
        function handleDesignerOptionClick() {

            option2.style.borderColor = '';


            option1.style.borderColor = 'rgba(187,186,186,0.89)';

        }

        function handleClientOptionClick() {

            option1.style.borderColor = '';


            option2.style.borderColor = 'rgba(187,186,186,0.89)';

        }


        // Hide the forms on page load
        document.addEventListener('DOMContentLoaded', function () {
            designerForm.style.display = 'none';
            clientForm.style.display = 'none';
        });

    </script>
</html>

