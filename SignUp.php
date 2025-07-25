<?php
//CHECK IF ALREADY LOGGED IN
include "php/redirect_auth.php"

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/signup.css">
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css"> -->
</head>
<body>
    <div id="header">
        <div id="brand">
            <h1>Aqua Del Sol</h1>
        </div>
    </div>

    
    <form method="post" id="signupForm">
        <div id="signupFormContainer">
            <div class="addmargin">
                <label for="username">Username<span style="color:red;">*</span> </label><br><input name="username" id="username" type="text" required><br><br>
                <label for="password">Password<span style="color:red;">*</span> </label><br><input name="password" id="password" type="password" required><br><br>
                <label for="email">Email<span style="color:red;">*</span> </label><br><input name="email" id="email" type="text" required><br><br>
            </div>
            <div class="addmargin2">
                <label for="fullname">Full Name </label><br><input name="fullname" id="fullname" type="text"><br><br>
                <label for="address">Address<span style="color:red;">*</span></label><br><input name="address" id="address" type="text" required><br><br>
                <label for="contact">Contact </label><br><input name="contact" id="contact" type="text"><br><br>
            </div>

        </div>
        <br>
        <input id="submitForm" type="submit" value="SIGN UP">
        <br><br>
        <a href="index.php">back</a>
    </form>
    
    
    <div id="footer">
        <div class="flex_center">
            <a href="ContactInfo.html"><h4>Where to find us</h4></a>
            <a href="PrivacyPolicy.html"><h4>Privacy Policy</h4></a>
        </div>     
    </div>

  <script src="js/signup.js"></script>
</body>
</html>