<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="css/reset.css" />
  <link rel="stylesheet" href="css/main.css" />
  <link rel="stylesheet" href="css/listproperty.css">
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
                <a href="loginConsultant.html">Login</a>
            </nav>
        </div>
        </div>
    </header>

    <img id="background-image"src="images/homepage-stock-photo.jpg" alt="property photo" />

    <div id="main">
        <div id="listPropertyContainer">
            <?php
                
                $addressLine1 = $_POST["addressLine1"];
                $addressLine2 = $_POST["addressLine2"];
                $town = $_POST["addressCityTown"];
                $postcode = $_POST["addressPostcode"];
                $description = $_POST["description"];
                $price = $_POST["price"];
                $bedrooms = $_POST["bedrooms"];
                $bathrooms = $_POST["bathrooms"];
                $type = $_POST["type"];
                $image = $_FILES["image"]["tmp_name"];
                $hidden = $_POST["availability"];

                echo "<h1>Property Details</h1>";
                echo "<p>Address Line 1: $addressLine1</p>";
                echo "<p>Address Line 2: $addressLine2</p>";
                echo "<p>Town: $town</p>";
                echo "<p>Postcode: $postcode</p>";
                echo "<p>Description: $description</p>";
                echo "<p>Price: $price</p>";
                echo "<p>Bedrooms: $bedrooms</p>";
                echo "<p>Bathrooms: $bathrooms</p>";
                echo "<p>Type: $type</p>";
                echo "<p>Availablity: $hidden</p>";

                echo("<br>");
                print_r($_POST);
                echo("<br><br>");
                print_r($_FILES);

                //php has to be written to have actual functionality in regards to database
            ?>
        </div>
    </div>
</body>