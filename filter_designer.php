<?php
// Establish database connection
$mysql = mysqli_connect("localhost", "root", "root", "360interiors");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category'])) {
    $category = $_POST['category'];

    if ($category == 'all') {
        $query = "SELECT * FROM Designer";
    } else {
        // Query to select designers based on the selected category
        $query = "SELECT DISTINCT D.*, DS.designCategoryID 
                    FROM Designer D 
                    INNER JOIN DesignerSpeciality DS ON D.id = DS.designerID 
                    WHERE DS.designCategoryID = '$category'";
    }

    $result = mysqli_query($mysql, $query);

    $designers = [];
    while ($row = mysqli_fetch_assoc($result)) {
    // Use brandName as the name property
    $row['name'] = $row['brandName'];

    // Fetch specialties for each designer
    $designerId = $row['id'];
    $specialties_query = "SELECT DC.category 
                          FROM DesignCategory DC 
                          INNER JOIN DesignerSpeciality DS ON DC.id = DS.designCategoryID 
                          WHERE DS.designerID ='$designerId'";
    $specialties_result = mysqli_query($mysql, $specialties_query);
    $specialties = [];
    while ($specialty_row = mysqli_fetch_assoc($specialties_result)) {
        $specialties[] = $specialty_row['category'];
    }
    $row['specialties'] = $specialties;
    $designers[] = $row;
}


    // Return designers as JSON
    echo json_encode($designers);
} else {
    // Invalid request method or missing category parameter
    echo json_encode(["error" => "Invalid request"]);
}
?>
