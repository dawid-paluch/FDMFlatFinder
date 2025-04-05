<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="css/reset.css" />
  <link rel="stylesheet" href="css/main.css" />
  <link rel="stylesheet" href="css/viewProperty.css" />
  <?php
  session_start();
  ?>
  <title>Web Dev Coursework</title>
</head>

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
                <a href="logout.php">Logout</a>
            </nav>
        </div>
        </div>
    </header>

    <img id="background-image"src="images/homepage-stock-photo.jpg" alt="property photo" />

    <div id="main">
        <div id="viewPropertyContainer">
            <h1>
                List of Properties Page
            </h1>
            <?php
            include 'connection.php';

            $userId = $_SESSION['userId'];

            $sql = "SELECT propertyId, addressLine1, addressCityTown, addressPostcode, price FROM propertyList WHERE userId = '$userId'";
            
            $query = mysqli_query($conn, $sql);
            if (!$query) {
                die("Query failed: " . mysqli_error($conn));
            }
            if (mysqli_num_rows($query) == 0) {
                echo "No properties found for this user.";
                exit;
            }

            if ($query -> num_rows > 0) {
                echo "<div id='tableContainer'>";
                echo "<form>";
                echo "<div id='tableHead'><p class='tableField line1Field'>Address</p><p class='tableField cityTownField'>City/Town</p><p class='tableField postcodeField'>Postcode</p><p class='tableField priceRow'>Price (£)</p></div>";
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<div class='tableRow'>";
                    echo "<button class='tableButton' type='submit' name='propertyId' value='" . $row['propertyId'] . "'></button>";
                    echo "<p class='tableField line1Field'>" . $row['addressLine1'] . "</p>";
                    echo "<p class='tableField cityTownField'>" . $row['addressCityTown'] . "</p>";
                    echo "<p class='tableField postcodeField'>" . $row['addressPostcode'] . "</p>";
                    echo "<p class='tableField priceRow'>£" . number_format($row['price']) . "</p>";
                    echo "</div>";
                    echo "</button>";
                }
                echo "</form>";
                echo "</div>";
            } else {
                echo "No properties found.";
            }
            ?>
        </div>
    </div>
</body>