<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'security.php';

$connection = mysqli_connect("localhost", "root", "root", "360interiors");

if (mysqli_connect_error()) {
    die("Cannot connect to the database: " . mysqli_connect_error());
}

// Check if the project_id is set in the query string
if (isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];
    $query = "SELECT * FROM designportfolioproject WHERE id = '$project_id'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $project_data = mysqli_fetch_assoc($result);
    }
}


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_id = $_POST['project_id'] ?? $project_data['id'];
    $project_name = !empty($_POST['projectName']) ? $_POST['projectName'] : $project_data['projectName'];
    $description = !empty($_POST['projectDescription']) ? $_POST['projectDescription'] : $project_data['description'];
    $projectImgFileName = $project_data['projectImgFileName']; 

    if (isset($_FILES["projectImage"]) && $_FILES["projectImage"]["error"] == UPLOAD_ERR_OK) {
        $file = $_FILES["projectImage"];
        $tempFilePath = $file["tmp_name"];
        $uploadDirectory = "uploads/";
        $fileName = basename($file["name"]);
        $destination = $uploadDirectory . $fileName;
        if (move_uploaded_file($tempFilePath, $destination)) {
            $projectImgFileName = $destination;
        }
    }

    $designCategoryID = $project_data['designCategoryID']; 
    if (!empty($_POST['designCategory'])) {
        $query = "SELECT * FROM designcategory WHERE category='" . $_POST['designCategory'] . "'";
        $result = mysqli_query($connection, $query);
        if ($row = mysqli_fetch_assoc($result)) {
            $designCategoryID = $row["id"];
        }
    }

    
    $update_query = "UPDATE designportfolioproject SET projectName = '$project_name', projectImgFileName='$projectImgFileName', description='$description', designCategoryID='$designCategoryID' WHERE id = '$project_id'";

    // Execute the update query
    if (mysqli_query($connection, $update_query)) {
        header('Location: DesignerHomePage.php'); // Redirect after update
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Update project</title>
        <link rel="stylesheet" href="unifiedstyle.css">
        <link rel="stylesheet" href="projectPage.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body {
                background-image: linear-gradient(180deg,
                    rgba(100,100 , 40, 0.75),
                    rgba(0, 0, 0, 0)
                    ,rgba(0, 0, 0, 0)), url('img/livingroom.jpg');
                background-repeat: no-repeat; /* Do not repeat the image */
                background-attachment: fixed; /* Fix the background image position */
                background-size: cover; /* Cover the entire viewport */
            }

        </style>
    </head>
    <body>
        <header>
            <h1>Project update page</h1>

            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="login.php">Home</a></li>
                <li class="breadcrumb-item"><a href="DesignerHomePage.php">Designer Homepage</a></li>
                <li class="breadcrumb-item"><a href="ProjectUpdatePage.php">Project Update</a></li>

            </ul>
        </header>
        <form action="ProjectUpdatePage.php?project_id=<?= $project_id ?>" method="post" enctype="multipart/form-data" class="projectAddform">
            <div class="form-group">
                <input type="hidden" name="project_id" value="<?php echo htmlspecialchars($project_id); ?>">
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
            <input type="submit" value="Update Project">
        </form>
        <footer class="footer">
            <p>Email: <a href="mailto:contact@360interiors.com">contact@360interiors.com</a></p>
            <p>&copy; 2024 360Interiors. All rights reserved.</p>
            <a href="https://instagram.com/yourusername" target="_blank">Instagram</a>
            <a href="https://example.com/youraccount" target="_blank">X Account</a>
        </footer>
    </body>
</html>
