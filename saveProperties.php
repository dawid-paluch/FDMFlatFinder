<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

include 'connection.php';

$input = json_decode(file_get_contents('php://input'), true);
$propertyId = isset($input['property_id']) ? intval($input['property_id']) : 0;
$userId = $_SESSION['userId'];

if (!$propertyId || !$userId) {
    echo json_encode(['success' => false, 'error' => 'Missing or invalid property_id or user_id']);
    exit;
}

// Check if this property is already saved
$check_sql = "SELECT * FROM saved_properties WHERE user_id = $userId AND property_id = $propertyId";
$check_result = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($check_result) > 0) {
    // Property is already saved – remove it
    $delete_sql = "DELETE FROM saved_properties WHERE user_id = $userId AND property_id = $propertyId";
    if (mysqli_query($conn, $delete_sql)) {
        echo json_encode(['success' => true, 'action' => 'unsaved']);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
} else {
    // Property not saved – add it
    $insert_sql = "INSERT INTO saved_properties (user_id, property_id) VALUES ($userId, $propertyId)";
    if (mysqli_query($conn, $insert_sql)) {
        echo json_encode(['success' => true, 'action' => 'saved']);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
}

?>
