<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['id'])) {
    echo "<p>alert('You have to be logged in to change any details');</p>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"]) {
    $new_username= $_POST['username'];
    $user_id = $_SESSION['id'];

    $sql = "UPDATE fdm_users SET username = '$new_username' WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['username'] = $new_username;
        echo "<script>alert('Your username has now been updated.'); window.location.href = 'account.php';</script>";
    } else {
        echo "<script>alert('There was an error updating the username, please try again.');</script>";
    }

    $conn->close();
}
?>
