<?php

$sname = "localhost";
$db_email = "root";
$db_password = "";
$db_name = "usersFDM";

$conn = mysqli_connect($sname, $db_email, $db_password, $db_name);

if (!$conn) {
    echo "Connection failed!" . mysqli_connect_error();
}

return $conn;
?>