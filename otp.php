<?php

session_start();

include "connection.php";

// if no email go back to login
if (!isset($_SESSION['email'])){
    header("Location: loginConsultant.html");
    exit();
}

// users email retrieved from session
$email = $_SESSION['email'];
$role = $_SESSION['role'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // gets otp typed by user
    $typed_otp = trim($_POST['otp']);

    // gets otp, and expiry from database
    $sql = "SELECT otp, otp_expiry FROM fdm_users WHERE email = '$email' AND role = '$role'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) ===1){
        $row = mysqli_fetch_assoc($result);
        $otp = $row['otp'];
        $otp_expiry = $row['otp_expiry'];

        // check if otp is expired
        if (time() > strtotime($otp_expiry)){
            echo '<script>
            alert("OTP has expired. Please request a new OTP.");
            window.location.href = "loginConsultant.html";
            </script>';
            exit();
        }

        // compare typed otp with otp from database
        if ($typed_otp === $otp){
            $sql = "UPDATE fdm_users SET otp = NULL, otp_expiry = NULL WHERE email = '$email' AND role = '$role'";
            $query = mysqli_query($conn, $sql);

            if ($query){
                $sql = "SELECT id FROM fdm_users WHERE email = '$email' AND role = '$role'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $_SESSION['userId'] = $row['id'];
                echo '<script>;
                alert("OTP verified");
                </script>';

                // redirect to pages depending on role
                if (isset($_SESSION['role']) && $_SESSION['role'] === 'consultant'){
                    header("Location: account.php");
                    exit();
                } else {
                    header("Location: account.php");
                    exit();
                }
                exit();
            } else {
                echo '<script>
                alert("Failed to verify OTP. Please try again.");
                window.location.href = "otp.html";
                </script>';
                exit();
            }
        } else {
            echo '<script>
            alert("Invalid OTP. Please try again.");
            window.location.href = "otp.html";
            </script>';
            exit();
        }
    }
}
?>

