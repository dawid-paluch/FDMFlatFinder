<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['userId'])) {
    echo "<p>alert('You have to be logged in to change any details');</p>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"]) {
    $new_email = $_POST['email'];
    $user_id = $_SESSION['userId'];

    $sql = "UPDATE fdm_users SET email = '$new_email' WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['email'] = $new_email;
        echo "<script>alert('Your email has now been updated.'); window.location.href = 'account.php';</script>";
    } else {
        echo "<script>alert('There was an error updating the email, please try again.');</script>";
    }

    $conn->close();
}
?>
