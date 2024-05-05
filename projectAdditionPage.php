<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Add project</title>
        <link rel="icon" type="image/png" href="img/logo_ver2-removebg-preview.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="projectPage.css">
        <link rel="stylesheet" href="unifiedstyle.css">

    </head>
    <body>
        <header>
            <h1>Project addition page</h1>

            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="DesignerHomePage.php">Designer Homepage</a></li>
                <li class="breadcrumb-item"><a href="project addition page.html">project Addition</a></li>

            </ul>
        </header>

        <form action="projectAdditionPage.php" method="post" enctype="multipart/form-data" class="projectAddform">

            <div class="form-group">
                <label for="projectName">Project Name</label><br>
                <input type="text" id="projectName" name="projectName" class="input">
            </div>
            <div class="form-group">
                <label for="projectImage">Project Image</label><br>
                <input type="file" id="projectImage" name="projectImage">
            </div>
            <div class="form-group">
                <label for="designCategory">Design Category</label><br>
                <select id="designCategory" name="designCategory">
                    <option>Country</option>
                    <option>Modern</option>
                    <option>Coastal</option>
                    <option>Minimalist</option>
                    <option>Bohemian</option>
                </select>
            </div>
            <div class="form-group">
                <label for="projectDescription">Description</label><br>
                <textarea id="projectDescription" name="projectDescription" class="input"></textarea>
            </div>
            <input type="submit" value="Add Project">
        </form>
        <?php
        session_start();
        $projectName = $_POST["projectName"];
        $description = $_POST["projectDescription"];
        //to retrive image path
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["projectImage"])) {
            $file = $_FILES["projectImage"];

            // Check if there was no error during file upload
            if ($file["error"] == UPLOAD_ERR_OK) {
               
                $tempFilePath = $file["tmp_name"]; // Temporary file path
                
                $uploadDirectory = "uploads/"; // Directory where to store uploaded files
                $fileName = basename($file["name"]);
                $destination = $uploadDirectory . time() . '_' . $fileName;

                if (move_uploaded_file($tempFilePath, $destination)) {
                    $projectImgFileName = $destination;
                }
            }
        }

        //establish database connection
        $mysql = mysqli_connect("localhost", "root", "root", "360interiors");

        //to retrive category name
        $query = "SELECT * FROM designcategory WHERE category='" . $_POST['designCategory'] . "'";
        $result = mysqli_query($mysql, $query);
        $row = mysqli_fetch_assoc($result);
        $designCategoryID = $row["id"];

        $query = "INSERT INTO designportfolioproject (designerID, projectName, projectImgFileName, description, designCategoryID) 
                        VALUES ('" . intval($_SESSION['userId']) . "', '$projectName', '$projectImgFileName', '$description', '$designCategoryID')";
        $result = mysqli_query($mysql, $query);
        if ($result) {
            header('Location: DesignerHomePage.php');
            exit();
        }
        ?>
        <footer class="footer">
            <p>Email: <a href="mailto:contact@360interiors.com">contact@360interiors.com</a></p>
            <p>&copy; 2024 360Interiors. All rights reserved.</p>
            <a href="https://instagram.com/yourusername" target="_blank">Instagram</a>
            <a href="https://example.com/youraccount" target="_blank">X Account</a>
        </footer>
    </body>
</html>


