<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['id'])) {
    echo "<p>alert('You have to be logged in to change any details');</p>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"]) {
    $new_age= $_POST['age'];
    $user_id = $_SESSION['id'];

    $sql = "UPDATE fdm_users SET age = '$new_age' WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['age'] = $new_age;
        echo "<script>alert('Your age has now been updated.'); window.location.href = 'account.php';</script>";
    } else {
        echo "<script>alert('There was an error updating the age, please try again.');</script>";
    }

    $conn->close();
}
?>
