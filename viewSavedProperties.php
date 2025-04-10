<!DOCTYPE html>
<html lang="en">
<head>
    
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="css/reset.css" />
  <link rel="stylesheet" href="css/main.css" />
  <link rel="stylesheet" href="css/viewSavedProperties.css" />
  <?php
  session_start();
  ?>
  <title>FDM Flat Finder</title>
</head>

<body>
    <header></header>
</body>

<body>
    <header>
        <div id="header">
        <div id="logo">
            <a href="mainpage.html">FlatFinderFDM</a>
        </div>

        <div id="nav">
            <nav>
                <a href="account.php">My Account</a>
                <a href="Tips.html">Tips</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
        </div>
    </header>

    <div id="main">
        <div id="savedPropertiesContainer">
            <h1>
                View Saved Properties
            </h1>
            <div id="returnButtonDiv"><a href="consultantHomePage.html">Return to Consultant Menu</a></div>
            <?php
                include 'connection.php';

                $sql = "SELECT p.*
                FROM propertyList p
                JOIN saved_properties sp ON p.propertyId = sp.property_id
                WHERE sp.user_id = " . $_SESSION['userId'];
            
                $query = mysqli_query($conn, $sql);
                if (!$query) {
                    die("Query failed: " . mysqli_error($conn));
                }
                if (mysqli_num_rows($query) == 0) {
                    echo "No properties found according to these requirements.";
                    exit;
                }

                if ($query -> num_rows > 0) {
                    echo "<div id='tableContainer'>";
                    echo "<form id='propertyListForm' method='POST' action='consultantPropertySpecific.php'>";
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo "<div class='tableRow'>";
                            echo "<div class='imageField'><img src='uploads/".$row['image_name']."' alt='Property Image'></div>";
                            echo "<div class='propertyInfo'>";
                                echo "<button class='propertyDetailsButton' type='submit' name='propertyId' value='" . $row['propertyID'] . "'>";
                                    echo "<div class='propertyDetailsButtonDiv'>";
                                        echo "<p class='addressField'>" . strtoupper($row['addressLine1']) . ", " . strtoupper($row['addressCityTown']) . ", " . strtoupper($row['addressPostcode']) . "</p>";
                                        echo "<div class='detailsField'>";
                                            echo "<p class='priceRow'}>Price: £" . number_format($row['price']) . "</p>";
                                            echo "<p class='typeRow'>Type: " . ucfirst($row['type']) . "</p>";
                                            echo "<p class='bedroomsRow'>Bedrooms: " . $row['bedrooms'] . "</p>";
                                            echo "<p class='bathroomsRow'>Bathrooms: " . $row['bathrooms'] . "</p>";    
                                        echo "</div>";
                                        echo "<p class='descriptionField'>" . $row['description'] . "</p>";
                                    echo "</div>";
                                echo "</button>";
                                echo "<div class='bottomField' data-id='" . $row['propertyID'] . "'>";
                                    echo "<p class='dateUpdated'>Date Updated: " . $row['dateUpdated'] . "</p>";
                                    echo "<button id='saveButton' class='saveButton saved' type='button' name='saveProperty' value='" . $row['propertyID'] . "'>Save</button>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    }
                    echo "</form>";
                    echo "</div>";
                } else {
                    echo "No properties found.";
                }
            ?>
        </div>
    </div>
    <script src="javascript/inputNumberDisableScroll.js"></script>
    <script src="javascript/saveProperty.js"></script>
</body>
