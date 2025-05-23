<?php
//* PHP file responsible for resetting password
// This file handles the password reset process after the user has clicked on the link sent to their email. It checks if the token is valid and not expired, and if so, redirects the user to the reset password page. It also includes a connection to the database and provides feedback to the user upon successful or failed token validation.

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

