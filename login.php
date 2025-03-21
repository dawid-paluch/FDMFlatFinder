<?php
session_start();

echo 'Hello';

include 'connection.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

$email = validate($_POST['email']);
$password = validate($_POST['password']);

if (empty($email) || empty($password)){
    header("Location: login.php?error=Email and Password is required");
    exit();
}

$sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password' ";
$result = $conn->query($sql);

if($result->num_rows ===1){
    $row = $result->fetch_assoc();


    if ($row['email'] === $email && $row['password'] === $password) {
        $_SESSION['email'] = $row['email'];
        $_SESSION['password'] = $row['password'];
        $_SESSION['role'] = $row['role'];

    if ($row['role'] === 'consultant')
    {
        header ("Location: consultantHomePage.html");
        exit();
    } 
    else if ($row['role'] === 'landlord')
    {
        header ("Location: landlordHomePage.html");
        exit();
    }
}
    else{
        header("Location: login.php?error=Incorrect Email or Password");
        exit();
    }
}
else{
    header("Location: login.php?error=Incorrect Email or Password");
    exit();
} 

}
?>