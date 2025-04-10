<?php
// PHP file responsible for logout functionality
// This file handles the logout process by destroying the session and redirecting the user to the login page. It ensures that all session variables are cleared and the user is logged out securely.

session_start();

// remove all session variables
session_unset();
session_destroy();

// redirect to login page
header("Location: loginConsultant.html");
?>
