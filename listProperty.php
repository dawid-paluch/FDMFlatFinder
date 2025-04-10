<?php
session_start();

//PHP file responsible for listing a property
// This file handles the form submission for listing a property by a landlord. It validates the input data, processes the image upload, and inserts the property details into the database.
// It also includes a connection to the database and provides feedback to the user upon successful or failed property listing.

//connects to database
include 'connection.php';

function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if (isset($_POST['listProperty'])) {

    // checks if form is submitted and register button is clicked
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['listProperty'])) {

        $userId = $_SESSION['userId'];

        // gets data from the form and validate it
        $addressLine1 = validate($_POST['addressLine1']);
        $addressLine2 = validate($_POST['addressLine2']);
        $addressCityTown = validate($_POST['addressCityTown']);
        $addressPostcode = validate($_POST['addressPostcode']);
        $description = validate($_POST['description']);
        $price = validate($_POST['price']);
        $bedrooms = validate($_POST['bedrooms']);
        $bathrooms = validate($_POST['bathrooms']);
        $type = validate($_POST['type']);
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $availability = $_POST['availability'];

        $sql = "INSERT INTO propertyList (userId, addressLine1, addressLine2, addressCityTown, addressPostcode, description, price, bedrooms, bathrooms, type, image_name, availability) VALUES ('$userId', '$addressLine1', '$addressLine2', '$addressCityTown', '$addressPostcode', '$description', '$price', '$bedrooms', '$bathrooms', '$type', '$image_name', '$availability')";
        $query = mysqli_query($conn, $sql);

        // checks if the query is successful and image is uploaded
        if ($query) {
            
            move_uploaded_file($image_tmp, "uploads/$image_name");
            echo "<script>        
                alert('Property listed successfully');
                window.location.href = 'landlordHomePage.html';
            </script>";
        } else {
            echo "Property listing failed";
        }


    }
}
?>
