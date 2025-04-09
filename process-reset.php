<?php
// gets token from reset password form
$token = $_POST['token'];

$token_hash = hash("sha256", $token); // hash token

$conn = require __DIR__ . '/connection.php';

$sql = "SELECT * FROM fdm_users WHERE reset_token = ?";

// prepare SQL statement
$stmt = $conn-> prepare($sql);
$stmt -> bind_param("s", $token_hash);
$stmt -> execute();

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

// hash new password
$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

// update password and clear reset token and expiry
$sql = "UPDATE fdm_users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id=?";

$stmt = $conn -> prepare($sql);
$stmt -> bind_param("ss", $password_hash, $user['id']);
$stmt -> execute();

echo "<script>alert('Password reset successfully. You can now log in.'); window.location.href = 'loginConsultant.html';</script>";
