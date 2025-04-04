<?php
  session_start();
  include 'connection.php';
  
  if (isset($_SESSION['userId'])) {  
    $userId = $_SESSION['userId'];

    $sql = "SELECT role FROM fdm_users WHERE id = '$userId'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
      die("Query failed: " . mysqli_error($conn));
    }
    if (mysqli_num_rows($result) == 0) {
      echo "No user found with this ID.";
      exit;
    }
    $row = mysqli_fetch_assoc($result);
    $role = $row['role'];
    if ($role == 'consultant') {
      // Redirect to the consultant page
      header("Location: consultantHomePage.html");
      exit();
    } elseif ($role == 'landlord') {
      // Redirect to the admin page
      header("Location: landlordHomePage.html");
      exit();
    } else {
      // Redirect to login page if role is not recognized
      header("Location: loginConsultant.html");
      exit();
    }
  }
  else {
    // Redirect to login page if userId is not set in session
    header("Location: loginConsultant.html");
    exit();
  }
?>