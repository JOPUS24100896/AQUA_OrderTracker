<?php
include "../php/cust_auth.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/orderHistory.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css">
</head>

<body>
    <div id="header" class="flex_center">
        <div id="brand_Admin">
            <a href="../index.php"><h1>Aqua Del Sol</h1></a>
        </div>
        <ul id="navbar">
            <li><a href="CreateOrder.php">CREATE ORDER</a></li>
            <li><a href="Orders.php">PENDING ORDERS</a></li>
            <li><a href="OrderHistory.php" id="current">ORDER HISTORY</a></li>
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
        <h1 id="page_title">ORDER HISTORY</h1>
        <div class="HistoryList">
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Item Quantity</th>
                        <th>Price</th>
                        <th>Order Date</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody id="table_history">

                </tbody>
            </table>
        </div>

    </div>



    <div id="footer">
        <div class="flex_center">
            <a href="/ContactInfo.html">
                <h4>Where to find us</h4>
            </a>
            <a href="/PrivacyPolicy.html">
                <h4>Privacy Policy</h4>
            </a>
        </div>
    </div>

    <script src="../js/dropdown.js"></script>
    <script src="../js/orderHistory.js"></script>
</body>

</html>