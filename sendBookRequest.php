<?php
//* PHP file responsible for saving or unsaving a property
// This file handles the saving and unsaving of properties by a user. It checks if the property is already saved and either adds or removes it from the saved properties list. It also includes a connection to the database and provides feedback to the user upon successful or failed save/unsave action.

header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

include 'connection.php';

// This part of the code checks if the user is logged in and retrieves the property ID from the request. If the user is not logged in or the property ID is missing, it returns an error message.
if (!isset($_SESSION['userId'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit;
}
$input = json_decode(file_get_contents('php://input'), true);
$propertyId = isset($input['property_id']) ? intval($input['property_id']) : 0;
$userId = $_SESSION['userId'];

if (!$propertyId || !$userId) {
    echo json_encode(['success' => false, 'error' => 'Missing or invalid property_id or user_id']);
    exit;
}

// Check if this property is already saved
$check_sql = "SELECT * FROM propertylist WHERE propertyId = $propertyId AND bookID = $userId";
$check_result = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($check_result) > 0) {
    // Property is already saved – remove it
    $delete_sql = "UPDATE propertylist SET bookID = NULL WHERE propertyID = $propertyId";
    if (mysqli_query($conn, $delete_sql)) {
        echo json_encode(['success' => true, 'action' => 'unsaved']);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
} else {
    // Property not saved – add it
    $insert_sql = "UPDATE propertylist SET bookID = $userId WHERE propertyID = $propertyId";
    if (mysqli_query($conn, $insert_sql)) {
        echo json_encode(['success' => true, 'action' => 'saved']);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
}

?>
