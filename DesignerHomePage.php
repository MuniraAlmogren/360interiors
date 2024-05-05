<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'security.php';

$connection = mysqli_connect("localhost", "root", "", "360interiors");

if (mysqli_connect_error()) {
    die("Cannot connect to database: " . htmlspecialchars(mysqli_connect_error()));
}

// Retrieve the designer's information based on the session variable.
$designer_id = $_SESSION['userId'];

// Query to fetch designer specialties
$specialtyQuery = "SELECT designCategoryID FROM designerspeciality WHERE designerID = $designer_id";
$specialtyResult = mysqli_query($connection, $specialtyQuery);

$categories = []; //  to store categories.

if (mysqli_num_rows($specialtyResult) > 0) {
    while ($specialtyRow = mysqli_fetch_assoc($specialtyResult)) {
        $categoryId = $specialtyRow['designCategoryID'];
        $categoryQuery = "SELECT category FROM designcategory WHERE id = $categoryId";
        $categoryResult = mysqli_query($connection, $categoryQuery);
        while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
            $categories[] = $categoryRow['category'];
        }
    }
}



$query = "SELECT * FROM designer WHERE id = '$designer_id'";
$result = mysqli_query($connection, $query);

$designer_info = mysqli_fetch_assoc($result);

// to store projects and consultations.
$projects = [];
$consultations = [];


$projects_query = "
    SELECT 
        dp.id, 
        dp.projectName, 
        dp.projectImgFileName, 
        dp.description, 
        dp.designCategoryID,
        dc.category AS categoryName
    FROM 
        designportfolioproject dp
    INNER JOIN 
        designcategory dc ON dp.designCategoryID = dc.id
    WHERE 
        dp.designerID = '$designer_id'";
$projects_result = mysqli_query($connection, $projects_query);

if ($projects_result && mysqli_num_rows($projects_result) > 0) {
    while ($row = mysqli_fetch_assoc($projects_result)) {
        $projects[] = $row;
    }
} 

// Consultations query.
$consultations_query = "
    SELECT 
        c.firstName AS client_name, 
        rt.type AS room_type, 
        CONCAT(dr.roomWidth, 'x', dr.roomLength) AS dimensions, 
        dc.category AS design_category, 
        dr.colorPreferences, 
        dr.date,
        rs.status AS request_status,
        dr.id
    FROM 
        designconsultationrequest dr
    JOIN 
        client c ON dr.clientID = c.id
    JOIN 
        roomtype rt ON dr.roomTypeID = rt.id
    JOIN 
        designcategory dc ON dr.designCategoryID = dc.id
    JOIN 
        requeststatus rs ON dr.statusID = rs.id
    WHERE 
        dr.designerID = '$designer_id ' AND rs.status = 'pending consultation';
";

$consultations_result = mysqli_query($connection, $consultations_query);

if ($consultations_result && mysqli_num_rows($consultations_result) > 0) {
    while ($row = mysqli_fetch_assoc($consultations_result)) {
        $consultations[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Designer Homepage</title>
        <link rel="stylesheet" href="unifiedstyle.css">
        <link rel="stylesheet" href="designerStyle.css">
        <style>
            body {
                background-image: linear-gradient(180deg,
                    rgba(100,100 , 40, 0.75),
                    rgba(0, 0, 0, 0)
                    ,rgba(0, 0, 0, 0)), url('img/livingroom.jpg');
                background-repeat: no-repeat; 
                background-attachment: fixed; 
                background-size: cover; 
            }

        </style>
    </head>
   <script>
document.addEventListener('DOMContentLoaded', function() {
  const deleteLinks = document.querySelectorAll('.delete-project');

  deleteLinks.forEach(link => {
    link.addEventListener('click', function(event) {
      event.preventDefault();
      const projectId = this.getAttribute('data-project-id');

      if (confirm("Are you sure you want to delete this project?")) {
        // Send AJAX request
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'ProjectDeletePage.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
            const response = xhr.responseText.trim();
            if (response === 'true') {
              // Remove the corresponding row from the HTML table
              const row = document.getElementById(`projectRow_${projectId}`);
              row.parentNode.removeChild(row);
            }
            // You can handle unsuccessful deletion silently if needed
          }
        };
        xhr.send(`project_id=${projectId}`);
      }
    });
  });
});
</script>

    <body>
        <h1>Designer Homepage</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>

            <li class="breadcrumb-item"><a href='DesignerHomePage.php'>Designer HomePage</a></li>

        </ul>
        <div class="header">
            <div id="welcome">Welcome <?= htmlspecialchars($designer_info['firstName'] ?? '') ?></div>
            <div class="floatRight1"><a href="index.html">Log-out</a></div>
        </div>
        <div id="designerInfo">
<?php
echo $designer_info['firstName'] . ' ' . $designer_info['lastName'] . "<br>" .
 $designer_info['emailAddress'] . "<br>" .
 $designer_info['brandName'] . "<br>";

echo '<img src="' . htmlspecialchars($designer_info['logoImgFileName']) . '" alt="Brand Logo" width="100"><br>';

echo "Specialties:<br>";
?>
            <div id="small">
            <?php
            foreach ($categories as $category) {
                echo htmlspecialchars($category) . "<br>";
            }
            ?>
            </div>
        </div>

        <div class="table">
            <span class="change2">Designer portfolio</span>  
            <div class="floatRight2">  <a href="projectAdditionPage.php" class="add-project">Add New Project</a> </div>
<?php if (!empty($projects)) { ?>

                <table>
                    <tr>
                        <th>Project Name</th>
                        <th>Image</th>
                        <th>Design Category</th>
                        <th>Description</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
    <?php foreach ($projects as $project) { ?>
                        <tr>
                            <td><?= htmlspecialchars($project['projectName']) ?></td>
                            <td><img src="<?= htmlspecialchars($project['projectImgFileName']) ?>" alt="Project Image" width="100"></td>
                            <td><?= htmlspecialchars($project['categoryName']) ?></td>
                            <td><?= htmlspecialchars($project['description']) ?></td>
                            <td><a href="ProjectUpdatePage.php?project_id=<?= $project['id'] ?>">Edit</a></td>
                            <td><a href="#" class="delete-project" data-project-id="<?= $project['id'] ?>">Delete</a></td>

                        </tr>
    <?php } ?>
                </table>
            </div>

<?php } ?>
    </div>

    <div class="table">
        <span class="change2">Design Consultation Requests</span>
        <?php if (!empty($consultations)) { ?>

            <table>
                <tr>
                    <th>Client</th>
                    <th>Room</th>
                    <th>Dimensions</th>
                    <th>Design Category</th>
                    <th>Color Preferences</th>
                    <th>Date</th>
                    <th>Provide</th>
                    <th>Decline</th>
                </tr>
    <?php foreach ($consultations as $consultation) { ?>
                    <tr>
                        <td><?= htmlspecialchars($consultation['client_name']) ?></td>
                        <td><?= htmlspecialchars($consultation['room_type']) ?></td>
                        <td><?= htmlspecialchars($consultation['dimensions']) ?></td>
                        <td><?= htmlspecialchars($consultation['design_category']) ?></td>
                        <td><?= htmlspecialchars($consultation['colorPreferences']) ?></td>
                        <td><?= htmlspecialchars($consultation['date']) ?></td>
                        <td><a href="DesignConsultation.php?request_id=<?= $consultation['id'] ?>">Provide</a></td>
                        <td><a href="declineConsultation.php?request_id=<?= $consultation['id'] ?>">Decline</a></td>
                    </tr>
    <?php } ?>
            </table>
        </div>

<?php } ?>
</div>
<footer class="footer">
    <p>Email: <a href="mailto:contact@360interiors.com">contact@360interiors.com</a></p>
    <p>&copy; 2024 360Interiors. All rights reserved.</p>
    <a href="https://instagram.com/yourusername" target="_blank">Instagram</a>
    <a href="https://example.com/youraccount" target="_blank">X Account</a>
</footer>  
</body>
</html>
