<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['error']) && $_GET['error'] === 'emaildontExists') {
    echo '<script>alert("The email address you entered don\'t exists. Please sign up first.");</script>';
}

if (isset($_GET['error']) && $_GET['error'] === 'pleasetryagain') {
    echo '<script>alert("There is an issue ,try log-in another time.");</script>';
}

//connect to DB
$conn = mysqli_connect('localhost', 'root', 'root', '360interiors');
if (mysqli_connect_error()) {
    exit(mysqli_error($conn));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // form data field 
    $usertype = $_POST['select'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    if ($usertype == 'designer') {

        $sqlgetdesigner = "SELECT id ,emailAddress ,password FROM designer WHERE emailAddress='$email'";
        $result3 = mysqli_query($conn, $sqlgetdesigner);

        if (mysqli_num_rows($result3) == 0) {
            // Email exists, redirect back with an error message(GET)
            header('Location: login.php?error=emaildontExists');
            exit();
        }

        $designerfetch = mysqli_fetch_assoc($result3);
        if (($designerfetch['emailAddress'] == $email) && (password_verify($pass, $designerfetch['password']))) {
            $_SESSION['userId'] = $designerfetch['id'];
            $_SESSION['userType'] = $usertype;
            header('Location: DesignerHomePage.php');
            exit();
        } else {
            header('Location: login.php?error=pleasetryagain');
            exit();
        }
    } else if ($usertype == 'client') {

        $sqlgetclient = "SELECT id, emailAddress, password FROM client WHERE emailAddress='$email'";
        $result4 = mysqli_query($conn, $sqlgetclient);

        if (mysqli_num_rows($result4) == 0) {
            // Email dont exists, redirect back with an error message(GET)
            header('Location: login.php?error=emaildontExists');
            exit();
        }

        $clientfetch = mysqli_fetch_assoc($result4);
        if (($clientfetch['emailAddress'] == $email) && (password_verify($pass, $clientfetch['password']))) {
            $_SESSION['userId'] = $clientfetch['id'];
            $_SESSION['userType'] = $usertype;
            header('Location: clientHomepage.php');
            exit();
        } else {
            header('Location: login.php?error=pleasetryagain');
            exit();
        }
    } else {
        header('Location: login.php');
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Log in</title>
        <link rel="stylesheet" href="login.css">
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
                <form class="form-container" id="login_form" action="login.php" method="post" enctype="multipart/form-data">
                    <h1>Welcome Back!</h1>

                    <div class="label-container">
                        <label for="email">Email Address:</label>
                        <input type="email" id="email" name="email" required>

                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <hr>

                    <div class="wrapper">
                        <input type="radio" name="select" id="d-option-1" value="designer">
                        <input type="radio" name="select" id="c-option-2" value="client">
                        <label for="d-option-1" class="option option-1">
                            <span>Designer</span>
                        </label>
                        <label for="c-option-2" class="option option-2">
                            <span>Client</span>
                        </label>
                    </div>

                    <button type="submit">Submit</button>
                    <p class="signup-link">New User? <a href="sign.php"> Sign Up</a></p>
                </form>
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

        const myForm = document.getElementById('login_form');
        const designerOption = document.getElementById('d-option-1');
        const clientOption = document.getElementById('c-option-2');


        option1.addEventListener('click', handleDesignerOptionClick);
        option2.addEventListener('click', handleClientOptionClick);


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

