<?php

//gets token from URL and hashes it
$token = $_GET['token'];
$token_hash = hash("sha256", $token);

$conn = require __DIR__ . '/connection.php';

// prepare SQL query to check if user with hashed token exists
$sql = "SELECT * FROM fdm_users WHERE reset_token = ?";
$stmt = $conn-> prepare($sql);
$stmt -> bind_param("s", $token_hash);
$stmt -> execute();

// get result
$result = $stmt -> get_result();
$user = $result -> fetch_assoc();

// check if theres a user with the token
if ($user == null) {
    echo "<script>alert('Invalid token. Please try again.'); window.location.href = 'forgot_password.html';</script>";
    exit;
}

// check if token is expired if not allow user to reset password
if (strtotime($user['reset_token_expiry']) < time()){
    echo "<script>alert('Token expired. Please try again.'); window.location.href = 'forgot_password.html';</script>";
    exit;
}

echo "<script>'window.location.href = reset-password.html?token=$token' </script>";
?>

