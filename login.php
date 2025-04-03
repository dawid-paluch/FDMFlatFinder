<?php

session_start();
echo session_save_path();

include "connection.php";

// imports PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// load PHPMailer files
require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

// checks if form submitted
if ($_SERVER["REQUEST_METHOD"]) {
    // gets data from form
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $_SESSION['email'] = $email;

    // sql query to find user with the provided email and role
    $sql = "SELECT * FROM fdm_users WHERE email = '$email' AND role = '$role'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $_SESSION['role'] = $row['role'];

    // checks if user exists and password is correct
    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['id'] = $row['id'];
        // otp expiry datetime created - 5minutes
        $otp_expiry = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        // email details and message
        $subject = "One Time Password";
        $otp = rand(100000, 999999);
        $message = "Your OTP is: " . $otp;

        // new instance of PHPMailer, and SMTP used to send email
        $mail = new PHPMailer(true);
        $mail->isSMTP(); 
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'fdm.otp@gmail.com'; // host email
        $mail->Password = 'bjdl qnwm cpis kxlu'; // host passwords - connects to SMTP server
        $mail->Port = 465; 
        $mail->SMTPSecure = 'ssl';
        $mail->isHTML(true);

        // sender and receiver email
        $mail->setFrom('fdm.otp@gmail.com', 'FDM Flat Finder OTP');
        $mail->addAddress($email);

        // email subject and message
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->send(); //sends email

        // updates user otp and otp expiry in database
        $sql = "UPDATE fdm_users SET otp = '$otp', otp_expiry = '$otp_expiry' WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        //user redirected to the otp verification page
        header("Location: otp.html");
        exit();

        //error message if email or password is incorrect
    } else {
        echo '<script>
        alert("Invalid email or password. Please try again.");
        window.location.href = "loginConsultant.html";
        </script>';
        exit();
    }
}

