<!DOCTYPE html>
<html lang="en">
<head>
    
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="css/reset.css" />
  <link rel="stylesheet" href="css/main.css" />
  <link rel="stylesheet" href="css/searchProperty.css" />
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
                <a href="mainpage.html">Home</a>
                <a href="about.html">About</a>
                <a href="contact.html">Contact</a>
                <a href="account.php">My Account</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
        </div>
    </header>

    <div id="main">
        
        <form id="searchPropertyForm" method="post" action="searchProperty.php">
            <label for="addressLine1">Address:</label>
            <input type="text" id="addressLine1" name="addressLine1" placeholder="Enter Address">

            <label for="addressPostcode">Postcode:</label>
            <input type="text" id="addressPostcode" name="addressPostcode">

            <label for="minPrice">Min Price (£):</label>
            <input type="range" value="0" id="minPrice" name="minPrice" placeholder="Enter Min Price" min="0" max="20000000" step="100" oninput="this.nextElementSibling.value = '£'+Number(this.value).toLocaleString();">
            <output>£0</output>

            <label for="bedrooms">Bedrooms:</label>
            <input type="number" id="bedrooms" name="bedrooms" min="1" onwheel="disableScroll(event)">

            <label for="addressCityTown">City/Town:</label>
            <input type="text" id="addressCityTown" name="addressCityTown" placeholder="Enter City/Town">

            <label for="type">Type:</label>
            <select id="type" name="type" required>
                <option value="house">House</option>
                <option value="apartment">Apartment</option>
                <option value="flat">Flat</option>
                <option value="studio">Studio</option>
            </select>

            <label for="maxPrice">Max Price (£):</label>
            <input type="range" value="5000000" id="maxPrice" name="maxPrice" placeholder="Enter Max Price" min="0" max="5000000" step="100" oninput="this.nextElementSibling.value = '£'+Number(this.value).toLocaleString();">
            <output>£5,000,000</output>

            <label for="bathrooms">Bathrooms:</label>
            <input type="number" id="bathrooms" name="bathrooms" min="1" onwheel="disableScroll(event)">

            <button type="submit" id="searchButton">Search</button>
        </form>
        <div id="searchPropertyContainer ">
            <h1>
                Search for Property
            </h1>
            <div id="returnButtonDiv"><a href="consultantHomePage.html">Return to Consultant Menu</a></div>
            <?php
                include 'connection.php';

                $sql = "SELECT propertyId, addressLine1, addressCityTown, addressPostcode, description, type, bedrooms, bathrooms, price, image_name, dateUpdated FROM propertyList";

                if (!empty($_POST)) {
                    $sql = $sql . " WHERE";
                    $addressLine1 = $_POST['addressLine1'];
                    $addressPostcode = $_POST['addressPostcode'];
                    $minPrice = $_POST['minPrice'];
                    $maxPrice = $_POST['maxPrice'];
                    $bedrooms = $_POST['bedrooms'];
                    $bathrooms = $_POST['bathrooms'];
                    $addressCityTown = $_POST['addressCityTown'];
                    $type = $_POST['type'];

                    if (!empty($addressLine1)) {
                        $sql = $sql . " addressLine1 LIKE '%$addressLine1%' AND";
                    }
                    if (!empty($addressPostcode)) {
                        $sql = $sql . " addressPostcode LIKE '%$addressPostcode%' AND";
                    }
                    if (!empty($minPrice)) {
                        $sql = $sql . " price >= '$minPrice' AND";
                    }
                    if (!empty($maxPrice)) {
                        $sql = $sql . " price <= '$maxPrice' AND";
                    }
                    if (!empty($bedrooms)) {
                        $sql = $sql . " bedrooms = '$bedrooms' AND";
                    }
                    if (!empty($bathrooms)) {
                        $sql = $sql . " bathrooms = '$bathrooms' AND";
                    }
                    if (!empty($addressCityTown)) {
                        $sql = $sql . " addressCityTown LIKE '%$addressCityTown%' AND";
                    }
                    if (!empty($type)) {
                        $sql = $sql . " type = '$type' AND";
                    }
                    // Remove the last 'AND' from the SQL statement
                    $sql = rtrim($sql, " AND");
                }
            
                $query = mysqli_query($conn, $sql);
                if (!$query) {
                    die("Query failed: " . mysqli_error($conn));
                }
                if (mysqli_num_rows($query) == 0) {
                    echo "No properties found according to these requirements.";
                    exit;
                }

                $sql = "SELECT property_id FROM saved_properties WHERE user_id = " . $_SESSION['userId'];
                $savedProperties = mysqli_query($conn, $sql);
                if (!$savedProperties) {
                    die("Query failed: " . mysqli_error($conn));
                }
                $savedPropertyIds = array();
                while ($row = mysqli_fetch_assoc($savedProperties)) {
                    $savedPropertyIds[] = $row['property_id'];
                }

                if ($query -> num_rows > 0) {
                    echo "<div id='tableContainer'>";
                    echo "<form id='propertyListForm' method='post' action='consultantPropertySpecific.php'>";
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo "<div class='tableRow'>";
                            echo "<div class='imageField'><img src='uploads/".$row['image_name']."' alt='Property Image'></div>";
                            echo "<div class='propertyInfo'>";
                                echo "<button class='propertyDetailsButton' name='propertyId' type='submit' name='propertyDetailsButton' value='" . $row['propertyId'] . "'>";
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
                                echo "<div class='bottomField' data-id='" . $row['propertyId'] . "'>";
                                    echo "<p class='dateUpdated'>Date Updated: " . $row['dateUpdated'] . "</p>";
                                    if (in_array($row['propertyId'], $savedPropertyIds)){
                                        echo "<button id='saveButton' class='saveButton saved' type='button' name='saveProperty' value='" . $row['propertyId'] . "'>Save</button>";
                                    }
                                    else {
                                        echo "<button id='saveButton' class='saveButton' type='button' name='saveProperty' value='" . $row['propertyId'] . "'>Save</button>";
                                    }
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
