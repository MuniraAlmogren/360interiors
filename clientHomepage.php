<?php
include 'security.php';
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>360 interiors</title>
        <!-- Add necessary CSS -->
        <link rel="stylesheet" href="unifiedstyle.css">
        <link rel="stylesheet" href="clientStyle.css">
        <style>
            body {
                background-image: linear-gradient(180deg, rgba(100, 100, 40, 0.75), rgba(0, 0, 0, 0), rgba(0, 0, 0, 0)),
                    url("img/livingroom.jpg");
            }
        </style>
    </head>
    <body>
        <header>
            <h1>Client Homepage</h1>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="clientHomepage.html">Client Homepage</a></li>
            </ul>  
        </header>

        <?php
        $_SESSION['userId'];
        $clientID = $_SESSION['userId'];

        //establish database connection
        $mysql = mysqli_connect("localhost", "root", "root", "360interiors");
        $query = "SELECT * FROM client WHERE id='$clientID'";
        $result = mysqli_query($mysql, $query);
        $row = mysqli_fetch_assoc($result);

        $fname = $row['firstName'];
        $lname = $row['lastName'];
        $email = $row['emailAddress'];
        ?>

        <p class="WelcomeMessage">Welcome <?php echo $fname; ?></p>

        <div style="position: absolute; left: 70vw; padding-top: 1em;"><a href="index.html">Log-out</a></div>

        <!-- Client information display -->
        <ul class="welcomeInfo" style="list-style: none;">
            <li><?php echo $fname . " " . $lname; ?></li>
            <li><?php echo $email; ?></li>
        </ul>

        <!-- Design category selection -->
        <form id="filterForm" method="post" action="filter_designer.php">
            <select name="DesignCategory" id="DesignCategory">
                <option value="all" selected>All</option>
                <?php
                $query = "SELECT * FROM designcategory";
                $result = mysqli_query($mysql, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['id'] . '">' . $row['category'] . '</option>';
                }
                ?>
            </select>
        </form>

        <!-- Designer table -->
        <div class="table">
            <table class="myTable">
                <caption>Interior Designer</caption>
                <thead>
                    <tr>
                        <th>Designer</th>
                        <th>Specialty</th>
                    </tr>
                </thead>
                <tbody id="designerTableBody" class='designerTableBody'>
                    <!-- Designers will be populated here -->
                </tbody>
            </table>
        </div>

        <!-- Previous design consultation requests table -->
        <div class="table">
            <!--A table of all the previous design consultation requests that the client has made-->
            <div class="table">
                <table>
                    <caption>Previous Design Consultation Requests</caption>

                    <tr>
                        <th>Designer</th>
                        <th>Room</th>
                        <th>Dimensions</th>
                        <th>Design Category </th>
                        <th>color Preference </th>
                        <th>request Date </th>
                        <th>Design Consultation </th>
                    </tr>

                    <?php
                    $query = "SELECT * FROM designconsultationrequest WHERE clientID='$clientID'";
                    $result = mysqli_query($mysql, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        //information for designer
                        $sql = "SELECT * FROM designer WHERE id='" . $row['designerID'] . "'";
                        $designerResult = mysqli_query($mysql, $sql);
                        $drsignerRow = mysqli_fetch_assoc($designerResult);
                        $brandName = $drsignerRow["brandName"];
                        $logo = $drsignerRow['logoImgFileName'];

                        //to get category 
                        $sql = "SELECT * FROM designcategory WHERE id='" . $row['designCategoryID'] . "'";
                        $categoryResult = mysqli_query($mysql, $sql);
                        $categoryRow = mysqli_fetch_assoc($categoryResult);
                        $categoryName = $categoryRow["category"];

                        //to get room type 
                        $sql = "SELECT * FROM roomtype WHERE id='" . $row['roomTypeID'] . "'";
                        $typeResult = mysqli_query($mysql, $sql);
                        $typeRow = mysqli_fetch_assoc($typeResult);
                        $typeName = $typeRow["type"];

                        //to get status
                        $sql = "SELECT * FROM requeststatus WHERE id='" . $row['statusID'] . "'";
                        $statusResult = mysqli_query($mysql, $sql);
                        $statusRow = mysqli_fetch_assoc($statusResult);
                        $status = $statusRow["status"];

                        echo ' <tr>';

                        echo '<td>';
                        echo $brandName;
                        echo '</td>';

                        echo '<td>';
                        echo $typeName;
                        echo '</td>';

                        echo '<td>';
                        echo $row['roomWidth'] . "X" . $row['roomLength'];
                        echo '</td>';

                        echo '<td>';
                        echo $categoryName;
                        echo '</td>';

                        echo '<td>';
                        echo $row['colorPreferences'];
                        echo '</td>';

                        echo '<td>';
                        echo $row['date'];
                        echo '</td>';

                        echo '<td>';
                        echo $status;
                        if ($status == 'consultation provided') {

                            $sql = "SELECT * FROM designconsultation WHERE requestID='" . $row['id'] . "'";
                            $imgResult = mysqli_query($mysql, $sql);
                            $imgRow = mysqli_fetch_assoc($imgResult);
                            $consultationImgFileName = $imgRow["consultationImgFileName"];

                            echo '<br><img src="' . $consultationImgFileName . '" width="100">';
                        }
                        echo '</td>';

                        echo '</tr>';
                    }
                    ?>
                </table>
            </div>
        </div>

        <!-- Add necessary JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function () {
                // Trigger AJAX request on page load for default option "all"
                triggerAjaxRequest();

                $(document).on("change", "#DesignCategory", function () {
                    // Trigger AJAX request when option changed
                    triggerAjaxRequest();

                });

                function triggerAjaxRequest() {
                    var value = $("#DesignCategory").val();
                    $.ajax({
                        url: "filter_designer.php",
                        type: "POST",
                        data: {category: value},
                        dataType: "json",
                        success: function (data) {
                            if (data) {
                                var html = ""; // Initialize html variable
                                $.each(data, function (index, designer) {
                                    var specialties = designer.specialties.join(', '); // Join specialties into a string
                                    html += '<tr><td>';
                                    html += '<span>' + designer.name + '</span>'; // Name
                                    html += '<br>'; // Line break
                                    html += '<img src="' + designer.logoImgFileName + '" alt="Logo" width="100">'; // Logo
                                    html += '</td>';
                                    html += '<td>' + specialties + '</td>'; // Specialties
                                    html += '<td><a href="requestConsultation.php?designerID=' + designer.id + '">Request Design Consultation</a></td></tr>';
                                });
                                $(".myTable tbody").html(html); // Update HTML content of table body
                            } else {
                                console.log("no data");
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log("Error:", error);
                        }
                    });
                }
            });


        </script>
    </body>
</html>
