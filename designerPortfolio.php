<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include "security.php";
?>



<!DOCTYPE html>

<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Portfolio</title>

        <!--to add the favicon-->
        <link rel="icon" type="image/png" href="img/logo_ver2-removebg-preview.png">
        <link rel="stylesheet" href="unifiedstyle.css">
        <link rel="stylesheet" href="clientStyle.css"/>
        <style>
            body {
                background-image: linear-gradient(180deg,
                    rgba(100, 100, 40, 0.75),
                    rgba(0, 0, 0, 0), rgba(0, 0, 0, 0)), url("img/livingroom.jpg");

            }
        </style>

    </head>
    <body>
        <header>

            <h1>Designer Portfolio</h1>

            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href='clientHomepage.php'>Client Homepage</a></li>
                <li class="breadcrumb-item"><a href='designerPortfolio.php'>Portfolio</a></li>

            </ul>
        </header>
        <?php
        // Establish database connection

        $c0nn = mysqli_connect("localhost", "root", "root", "360interiors");
        if (mysqli_connect_error()) {
            exit(mysqli_error($c0nn));
        }
        if (isset($_GET['requestID'])) {
            $designerIdp = mysqli_real_escape_string($c0nn, $_GET['requestID']);

            // Retrieve projects from the designer's design portfolio


            $queryRetrieveproject = "SELECT p.projectName, p.projectImgFileName,  p.description , c.category AS designCategory
              FROM designportfolioproject p
              INNER JOIN designcategory c ON p.designCategoryID = c.id
              WHERE p.designerID = $designerIdp";
            $resultRetrieval = mysqli_query($c0nn, $queryRetrieveproject);

            // Retrieve designer information
            $queryDinfo = "SELECT firstName, lastName, emailAddress, logoImgFileName FROM designer WHERE id = $designerIdp";
            $resultDinfo = mysqli_query($c0nn, $queryDinfo);
            $designerInfo = mysqli_fetch_assoc($resultDinfo);
        }
        ?>


        <span class="WelcomeMassage"><img src="img/<?php echo $designerInfo['logoImgFileName']; ?>" width="100"><br>
            <p class="WelcomeMassage">Welcome to <?php echo $designerInfo['firstName']; ?>'s portfolio page</p></span>

        <div class="logout"><a href="index.html">Log-out</a></div>

        <ul class="welcometInfo" style="list-style: none;">
            <li><?php echo $designerInfo['firstName'] . " " . $designerInfo['lastName']; ?></li>
            <li>Email Address: <?php echo $designerInfo['emailAddress']; ?></li>
        </ul>


        <div class="table">
            <table>
                <caption style="font-weight: bold;">Designer Portfolio</caption>
                <tr>
                    <th>Project Name</th>
                    <th>Image</th>
                    <th>Design Category</th>
                    <th>Description</th>
                </tr>
<?php
if ($resultRetrieval) {

    if (mysqli_num_rows($resultRetrieval) > 0) {

        while ($row = mysqli_fetch_assoc($resultRetrieval)) {

            echo "<tr>";
            echo "<td>" . $row['projectName'] . "</td>";
            echo '<td><img src="' . $row['projectImgFileName'] . '" width="100"></td>';
            echo "<td>" . $row['designCategory'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "</tr>";
        }
    } else {

        echo "<tr><td colspan='4'>No projects found.</td></tr>";
    }
} else {

    echo "Error: " . mysqli_error($c0nn);
}
?>



            </table>
        </div>
        <footer class="footer">
            <p>Email: <a href="mailto:contact@360interiors.com">contact@360interiors.com</a></p>
            <p>&copy; 2024 360Interiors. All rights reserved.</p>
            <a href="https://instagram.com/yourusername" target="_blank">Instagram</a>
            <a href="https://example.com/youraccount" target="_blank">X Account</a>
        </footer>
    </body>
</html>
