<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aqua Del Sol</title>
    <link rel="stylesheet" href="<?= base_url('css/main.css') ?>">
    <link rel="stylesheet" href="css/login.css">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">

</head>
<body>
    <div id="header">
        <div id="brand">
            <h1>Aqua Del Sol</h1>
        </div>
    </div>

    <form id="content" class="flex_center" method="post" action="orders/logInUser">
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
                <a href="orders/signup">
                    <h4>SIGN UP</h4>
                </a>
            </div>
        </div>
        <div id="about_us">
            <h2>ABOUT US</h2>
            <h3>Aqua del Sol is a water refilling station that is currently based in Yati, Liloan. As the name suggests, they deal with the filtration and distribution of clean drinkable water to their customers.</h3>

        </div>
    </form>     
    
    

    <?= $this->include("orders/footer")?>

</body>
</html>