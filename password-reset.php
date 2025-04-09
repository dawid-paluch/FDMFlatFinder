<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="css/reset.css" />
  <link rel="stylesheet" href="css/main.css" />
  <link rel="stylesheet" href="css/login.css" />
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
                <a href="mainpage.html">Home</a>
                <a href="about.html">About</a>
                <a href="contact.html">Contact</a>
                <a href="loginConsultant.html">Login</a>
            </nav>
        </div>
        </div>
    </header>

    <img id="background-image"src="images/homepage-stock-photo.jpg" alt="property photo" />

    <div id="main">
        <form method="POST" action="process-reset.php">
            
            <div class = "otp-container">
            <div id="formContainer">
                <h1>
                    Reset Password
                </h1>
                <input type = "hidden" name = "token"  value = "<?php echo $_GET['token']; ?>">
                <label for="password">New password</label>

                <input type = "password" name = "password" placeholder = "Enter new password" required>
                <label for="confirm_password">Repeat password</label>
                <input type = "password" name = "confirm_password" placeholder = "Repeat new password" required>
                <button type = "submit">Reset</button>
            </div>
            </div>
        </form> 
    </div>
</body>