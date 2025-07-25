<?php
//CHECK IF ALREADY LOGGED IN
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include "php/redirect_auth.php"
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aqua Del Sol</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div id="header">
        <div id="brand">
            <h1>Aqua Del Sol</h1>
        </div>
    </div>

    <form id="content" class="flex_center">
        <div id="log_in">
            <div id="account">
                <h3>Email or Username:</h3>
                <input id="email_or_phone" name="login_key" type="text" required>
            </div>
            <div id="password">
                <h3>Password:</h3>
                <input id="password_input" name="password" type="password" required>
            </div>
            <div id="log_in_button">
                <input type="submit" value="Log In">
            </div>
            <h4>Forgot Password?</h4>
            <div id="sign_up">
                <a href="SignUp.php">
                    <h4>SIGN UP</h4>
                </a>
            </div>
        </div>
        <div id="about_us">
            <h2>ABOUT US</h2>
            <h3>Aqua del Sol is a water refilling station that is currently based in Yati, Liloan. As the name suggests, they deal with the filtration and distribution of clean drinkable water to their customers.</h3>

        </div>
    </form>     
    
    

    <div id="footer">
        <div class="flex_center">
            <a href="ContactInfo.html"><h4>Where to find us</h4></a>
            <a href="PrivacyPolicy.html"><h4>Privacy Policy</h4></a>
        </div>     
    </div>
    <script src="js/login.js"></script>   
</body>
</html>