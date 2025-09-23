<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/contactinfo.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css">
    <style>
        #page_title {
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            text-shadow: 0px 0px 2px rgba(0, 0, 0, 0.875);
            font-weight: lighter;
            letter-spacing: .1cm;
        }
    </style>
</head>

<body>
    <div id="header" class="flex_center">
        <div id="brand_Admin">
            <a href="/index.php">
                <h1>Aqua Del Sol</h1>
            </a>
        </div>
        <ul id="navbar">
            <li><a href="<?=base_url('orders')?>">BACK</a></li>
        </ul>
    </div>

    <!--  content  -->
    <div id="content">
        <h1 id="page_title">Where to find us?</h1>
        <div id="contacts" class="flex_center">
            <div class="contactsBox">
                <h3>Location</h3>
                <p>9XGP+JQV, Simborio, Bag ong <br>Daan Rd, Liloan, Cebu</p>
                <br><br>
                <h3>Socials</h3>
                <p>Aqua Del Sol</p>
                <p style="font-size: 13px;">Facebook Page</p>

            </div>
            <div class="contactsBox">
                <h3>Contact Information </h3>
                <p>AquaDelSol@gmail.com</p>
                <p style="font-size: 13px;">Email Address <br><br><br><br></p>
                <h3>Phone Number</h3>
                <p>09123432981</p>
            </div>
        </div>
    </div>



    <div id="footer">
        <div class="flex_center">
            <a href="<?=base_url('orders/contactInfo')?>">
                <h4>Where to find us</h4>
            </a>
            <a href="<?=base_url('orders/privPolicy')?>">
                <h4>Privacy Policy</h4>
            </a>
        </div>
    </div>

</body>

</html>