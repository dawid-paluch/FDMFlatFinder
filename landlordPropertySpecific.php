<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="css/reset.css" />
  <link rel="stylesheet" href="css/main.css" />
  <link rel="stylesheet" href="css/landlordPropertySpecific.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
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
                <a href="account.php">My Account</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
        </div>
    </header>

    <img id="background-image"src="images/homepage-stock-photo.jpg" alt="property photo" />

    <div id="main">
        <div id="propertyDetailsContainer">
            <h1>
                Property Details
            </h1>
            <div id="returnButtonDiv"><a href="viewProperty.php">Return to List of Properties</a></div>
            <?php
            session_start();

            include 'connection.php';

            $propertyId = $_POST['propertyId'];

            $sql = "SELECT * FROM propertyList WHERE propertyId = '$propertyId'";

            $query = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($query);
            
            echo "<div class='propertyDetailsDiv'>";
                echo "<div class='imageField'><img src='uploads/".$row['image_name']."' alt='Property Image'></div>";
                echo "<div class='propertyInfo'>";
                    echo "<p class='addressField'>" . strtoupper($row['addressLine1']) . ", " . strtoupper($row['addressCityTown']) . ", " . strtoupper($row['addressPostcode']) . "</p>";
                    echo "<div class='detailsField'>";
                        echo "<p class='priceRow'}>Price: £" . number_format($row['price']) . "</p>";
                        echo "<p class='typeRow'>Type: " . ucfirst($row['type']) . "</p>";
                        echo "<p class='bedroomsRow'>Bedrooms: " . $row['bedrooms'] . "</p>";
                        echo "<p class='bathroomsRow'>Bathrooms: " . $row['bathrooms'] . "</p>";    
                    echo "</div>";
                    echo "<p class='descriptionField'>" . $row['description'] . "</p>";
                echo "</div>";
                echo "<div class='availabilityCalendarContainer'>";
                    echo "<h2>Current Availability Calendar</h2>";
                    echo "<input type='hidden' id='availabilityData' value='" . $row['availability'] . "'>";
                    echo "<div id='calendarHead'>";
                        echo "<button id='prev' class='btn disabled'><span class='material-symbols-outlined'>arrow_back</span></button>";
                        echo "<div id='month-year'></div>";
                        echo "<button id='next' class='btn'><span class='material-symbols-outlined'>arrow_forward</span></button>";
                    echo "</div>";
                    echo "<div id='weekdays'>";
                        echo "<div>Sun</div>";
                        echo "<div>Mon</div>";
                        echo "<div>Tue</div>";
                        echo "<div>Wed</div>";
                        echo "<div>Thu</div>";
                        echo "<div>Fri</div>";
                        echo "<div>Sat</div>";
                    echo "</div>";
                    echo "<div id='days'></div>";
                echo "</div>";
            echo "</div>";
            ?>
        </div>
    </div>
    <div id="emptyFillerDiv"></div>
    <script src="javascript/availabilityCalendarViewing.js"></script>
</body>