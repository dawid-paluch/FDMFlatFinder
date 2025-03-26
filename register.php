<?php
session_start();

//connects to database
include 'connection.php';

function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['register'])) {

    // checks if form is submitted and register button is clicked
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {

        // gets data from the form and validate it
        $username = validate($_POST['username']);
        $email = validate($_POST['email']);
        $password = validate($_POST['password']);
        $role = validate($_POST['role']);
        $age = validate($_POST['age']);
        $location = validate($_POST['location']); 

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // inserts data into database
        $sql = "INSERT INTO fdm_users(username, email, password, role, age, location) VALUES ('$username', '$email', '$hashedPassword', '$role', '$age', '$location')";
        $query = mysqli_query($conn, $sql);

        if ($query) {
            echo "<script>
                alert('Registration successful');
                window.location.href = 'loginConsultant.html';
            </script>";
        } else {
            echo "Registration failed";
        }
    }
}
?>
