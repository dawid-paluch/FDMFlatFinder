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
        $role = validate($_POST['role']);
        $age = validate($_POST['age']);
        $location = validate($_POST['location']); 

        $password = validate($_POST['password']);

        // password validation - checks if password is at least 8 characters long and contains at least one letter and one number
        $pattern = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/"; 
        if (!preg_match($pattern, $password)) {
            echo "<script>alert('Password must be at least 8 characters long and include at least one letter and one number.');</script>";
            exit();
        }

        //statement to check if the email already exits in the database
        $registerationCheck = $conn->prepare("SELECT * FROM fdm_users WHERE email = ?");
        $registerationCheck -> bind_param("s", $email);
        $registerationCheck -> execute();

        $result = $registerationCheck -> get_result();

        // if email exists, user alerted and redirected to login page
        if ($result->num_rows > 0) {
            echo "<script>
                alert('There is already an account with this email address.');
                window.location.href = 'loginConsultant.html';
                </script>";
                exit();
        }

        $registerationCheck -> close();

        // password hashed for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // insert data into the database
        $registrationCheck = $conn->prepare("INSERT INTO fdm_users (username, email, password, role) VALUES (?,?,?,?)");
        $registrationCheck->bind_param("ssss", $username, $email, $hashedPassword, $role);

        if ($registrationCheck->execute()) {
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
