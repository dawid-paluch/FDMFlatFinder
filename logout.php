<?php
session_start();

// remove all session variables
session_unset();
session_destroy();

// redirect to login page
header("Location: loginConsultant.html");
?>
