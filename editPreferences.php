<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Accommodation Preferences</title>
    <link rel="stylesheet" href="css/editPreferences.css">
    <link rel="stylesheet" href="css/reset.css">
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
    <div class="main">
        <h1>Edit Accommodation Preferences</h1>
        <div id="returnButtonDiv"><a href="consultantHomePage.html">Return to Consultant Menu</a></div>
        <form action="save_preferences.php" method="POST">
            <?php
            session_start();

            $sql = "SELECT * FROM fdm_users WHERE id = " . intval($_SESSION['userId']) . ";";
            include "connection.php";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                die("Error: " . mysqli_error($conn));
            }
            $row = mysqli_fetch_assoc($result);
            if (!$row) {
                die("Error: User not found.");
            }

            echo "<div class='form-group'>";
                echo "<label for='location'>Preferred City/Town</label>";
                echo "<input type='text' id='location' name='location' placeholder='Enter City/Town' value='" . htmlspecialchars($row['pref_location']) . "'>";
            echo "</div>";
            echo "<div class='form-group'>";
                echo "<label for='postcode'>Preferred Postcode</label>";
                echo "<input type='text' id='postcode' name='postcode' placeholder='Enter Postcode' value='" . htmlspecialchars($row['pref_postcode']) . "'>";
            echo "</div>";
            echo "<div class='form-group'>";
                echo "<label for='maxPrice'>Maximum Price(£)</label>";
                echo "<input type='number' id='maxPrice' name='maxPrice' min='100' max='5000000' step='100' onwheel='disableScroll(event)' placeholder='Enter Price' value='" . htmlspecialchars($row['pref_maxprice']) . "'>";
            echo "</div>";
            echo "<div class='form-group'>";
                echo "<label for='bedrooms'>Preferred Bedrooms</label>";
                echo "<input type='number' id='bedrooms' name='bedrooms' placeholder='Enter Bedrooms' min='1' onwheel='disableScroll(event)' value='" . htmlspecialchars($row['pref_bedrooms']) . "'>";
            echo "</div>";
            echo "<div class='form-group'>";
                echo "<label for='bathrooms'>Preferred Bathrooms</label>";
                echo "<input type='number' id='bathrooms' name='bathrooms' placeholder='Enter Bathrooms' min='1' onwheel='disableScroll(event)' value='" . htmlspecialchars($row['pref_bathrooms']) . "'>";
            echo "</div>";
            echo "<div class='form-group'>";
                echo "<label for='propertyType'>Property Type</label>";
                echo "<select name='propertyType' id='propertyType'>";
                    echo "<option value='Flat'>Flat</option>";
                    echo "<option value='House'>House</option>";
                    echo "<option value='Studio'>Studio</option>";
                echo "</select>";
                echo "<script>";
                    echo "document.getElementById('propertyType').value = '" . htmlspecialchars($row['pref_propertytype']) . "';";
                echo "</script>";
            echo "</div>";
            ?>

            <button type="submit">Save Preferences</button>
        </form>
    </div>
    <div id="emptyFillerDiv"></div>
    <script src="javascript/inputNumberDisableScroll.js"></script>
</body>

</html>
