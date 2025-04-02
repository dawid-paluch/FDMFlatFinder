<?php
session_start();

//database connection
include "connection_preferences.php";

//checks the user is logged in
if(!isset($_SESSION['user_id'])){
    echo "<h2>Login before editing preferences</h2>";
    echo "<a href='login.html'>Login</a>";
    exit();
}

function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//checks that the form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $location = validate($_POST['location']);
    $maxPrice = validate($_POST['maxPrice']);
    $minBedrooms = validate($_POST['minBedrooms']);
    $maxBedrooms = validate($_POST['maxBedrooms']);
    $minBathrooms = validate($_POST['minBathrooms']);
    $maxBathrooms = validate($_POST['maxBathrooms']);
    $propertyType = validate($_POST['propertyType']);

    //checks if any field is left empty
    if(empty($location) || empty($maxPrice) || empty($minBedrooms) || empty($maxBedrooms) || empty($minBathrooms)|| empty($maxBathrooms) || empty($propertyType)){
        echo "<h2>Please fill in all the fields</h2>";
        echo "<a href='editPreferences.html'>Return to Edit Preferences</a>";
        exit();
    }


    //data is inserted into the database
    $sql = "INSERT INTO preferences(location, maxPrice, minBedrooms, maxBedrooms, minBathrooms, maxBathrooms, propertyType) VALUES('$location', '$maxPrice', '$minBedrooms', '$maxBedrooms', '$minBathrooms', '$maxBathrooms', '$propertyType')";
    if(!mysqli_query($conn, $sql)){
        die("Error: " . mysqli_error($conn));
    }
    else{
        header("Location: mainpage.html");
        exit();
    }
}

?>
