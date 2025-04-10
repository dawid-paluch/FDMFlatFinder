<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="css/reset.css" />
  <link rel="stylesheet" href="css/account.css"/>
  
  <title>FDM Flat Finder</title>
</head>

<body>
    <header>
        <div id="header">
        <div id="logo">
            <a href="mainpage.html">FlatFinderFDM</a>
        </div>

        <div id="nav">
            <nav>
                <a href="account.php">My Account</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
        </div>
    </header>

    <img id="background-image"src="images/homepage-stock-photo.jpg" alt="property photo" />

    <div id="main">
        <?php if (isset($_SESSION['userId'])): ?>
                <div id="accountDetailsContainer">
                    <h1>
                        Your Personal Details
                    </h1>
                    <div id="detailtype-buttons">
                        <a id="returnButton" href="javascript:history.back()">Return to Menu</a>

                        <a id="email-button" href="changeEmail.html">Change Email</a>

                        <a id="password-button" href="changePassword.html">Change Password</a>

                        <a id="username-button" href="changeUsername.html">Change Username</a>

                        <a id="location-button" href="changeLocation.html">Change Location</a>
                        
                        <a id="age-button" href="changeAge.html">Change Age</a>
                </div>
        <?php else: ?>
            <div id="accountDetailsContainer">
                    <h1>
                        You must be logged in to access your account details
                    </h1>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>