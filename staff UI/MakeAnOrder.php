<?php
include "../php/staff_auth.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make an Order</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/createOrder.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css">
</head>

<body>
    <div id="header" class="flex_center">
        <div id="brand_Admin">
            <a href="../index.php"><h1>Aqua Del Sol</h1></a>
        </div>
        <ul id="navbar">
            <li><a href="../staff UI/MakeAnOrder.php" id="current">MAKE AN ORDER</a></li>
            <li><a href="../staff UI/ManageOrders.php" >MANAGE ORDERS</a></li>
            <li><a href="../staff UI/OrderRecordStaff.php">ORDER HISTORY</a></li>
            <li><a href="../staff UI/Deliveries.php">DELIVERIES</a></li>
        </ul>
        <div class="account-container">
            <img alt="User Account" class="account-icon" id="accountBtn" src="../images/dropdown_icon.jpg"></img>
            <div class="account-popup" id="accountPopup">
                <ul>
                    <a href="../ManageProfile.php" class="popopt">Manage Profile</a>
                    <a href="../php/EndSession.php" class="popopt">Logout</a>
                </ul>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div id="content">
        <h1 id="page_title">CREATE ORDER</h1>
        <form method="post" id="orderForm">
            <!--Order forms procedureally generated-->
            <div class="ProductList">
                <div id="Products" class="productCards"></div>
            </div>
        </form>

    </div>



    </div>


    <div id="footer">
        <div class="flex_center">
            <a href="../ContactInfo.html">
                <h4>Where to find us</h4>
            </a>
            <a href="../PrivacyPolicy.html">
                <h4>Privacy Policy</h4>
            </a>
        </div>
    </div>

    <script src="../js/productlist.js"></script>
    <script src="../js/createorder.js"></script>
    <script src="../js/dropdown.js"></script>
    <script>
        document.querySelectorAll('.ProductCard').forEach(card => {
            const minus = card.querySelector('button:first-child');
            const plus = card.querySelector('button:last-child');
            const count = card.querySelector('span');

            minus.addEventListener('click', () => {
                let val = parseInt(count.textContent);
                if (val > 0) count.textContent = val - 1;
            });

            plus.addEventListener('click', () => {
                let val = parseInt(count.textContent);
                count.textContent = val + 1;
            });
        });
    </script>

</body>

</html>
