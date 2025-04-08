<?php
session_start();

//database connection
include "connection.php";

//checks the user is logged in
if(!isset($_SESSION['userId'])){
    echo "Location: loginConsultant.html";
    exit();
}

function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$location = validate($_POST['location']);
$postcode = validate($_POST['postcode']);
$maxPrice = validate($_POST['maxPrice']);
$bedrooms = validate($_POST['bedrooms']);
$bathrooms = validate($_POST['bathrooms']);
$propertyType = validate($_POST['propertyType']);

// Start the SQL base
$sql = "UPDATE fdm_users SET ";

// Build an array of SET clauses
$updates = [];

if(!empty($location)){
    $updates[] = "pref_location = '".mysqli_real_escape_string($conn, $location)."'";
}
if(!empty($postcode)){
    $updates[] = "pref_postcode = '".mysqli_real_escape_string($conn, $postcode)."'";
}
if(!empty($maxPrice)){
    $updates[] = "pref_maxprice = '".mysqli_real_escape_string($conn, $maxPrice)."'";
}
if(!empty($bedrooms)){
    $updates[] = "pref_bedrooms = '".mysqli_real_escape_string($conn, $bedrooms)."'";
}
if(!empty($bathrooms)){
    $updates[] = "pref_bathrooms = '".mysqli_real_escape_string($conn, $bathrooms)."'";
}
if(!empty($propertyType)){
    $updates[] = "pref_propertytype = '".mysqli_real_escape_string($conn, $propertyType)."'";
}

// Only proceed if there's at least one field to update
if (!empty($updates)) {
    $sql .= implode(", ", $updates);
    $sql .= " WHERE id = " . intval($_SESSION['userId']) . ";";

    if(!mysqli_query($conn, $sql)){
        die("Error: " . mysqli_error($conn));
    } else {
        header("Location: consultantHomePage.html");
        exit();
    }
} else {
    header("Location: consultantHomePage.html");
    exit();
}

?>
