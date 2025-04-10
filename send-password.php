<?php
// PHP file responsible for sending password reset email
// This file handles the password reset process by generating a unique token, storing it in the database, and sending an email to the user with a link to reset their password. It uses PHPMailer for sending emails and includes error handling for email sending failures. It also includes a connection to the database and provides feedback to the user upon successful or failed email sending.

// imports PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// load PHPMailer files
require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

// gets email from submitted forgot password form
$email = $_POST['email'];

// random token generation
$token = bin2hex(random_bytes(16));

// hash created - returns 64 characters string
$token_hash = hash('sha256', $token);
$expiration_time = date("Y-m-d H:i:s", strtotime('+15 minutes'));

// database connection
$conn = require __DIR__ . '/connection.php'; // Include the database connection file

// updates user record with new token and expiration time
$sql = "UPDATE fdm_users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?";

$stmt = $conn->prepare($sql);
$stmt-> bind_param("sss", $token_hash, $expiration_time, $email);
$stmt->execute();

$mail = new PHPMailer(true);

// SMTP configuration
$mail->isSMTP(); 
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'fdm.otp@gmail.com'; // host email
$mail->Password = 'bjdl qnwm cpis kxlu'; // host passwords - connects to SMTP server
$mail->Port = 465; 
$mail->SMTPSecure = 'ssl';
$mail->isHTML(true);

// sender and receiver email
$mail->setFrom('fdm.otp@gmail.com', 'FDM Flat Finder Password Reset');
$mail->addAddress($email);

$subject = "Password Reset";
$message = "Click <a href= 'http://localhost/FDMFlatFinder1/password-reset.php?token=$token'> here</a>";

// email subject and message
$mail->Subject = $subject;
$mail->Body = $message;

// attempt to send email
try{
    $mail->send(); //sends email
    } catch (Exception $e) {
    echo "<script>alert('Reset password email could not be sent.'); window.location.href = 'forgot_password.html';</script>";
    }

echo "<script>alert('Password reset email sent successfully. Please check your inbox.'); window.location.href = 'forgot_password.html';</script>";
?>