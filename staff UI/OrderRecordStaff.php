<?php
include "../php/staff_auth.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Record</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/orderRecordStaff.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div id="header" class="flex_center">
        <div id="brand_Admin">
            <a href="../index.php"><h1>Aqua Del Sol</h1></a>
        </div>
        <ul id="navbar">
            <li><a href="../staff UI/MakeAnOrder.php" >MAKE AN ORDER</a></li>
            <li><a href="../staff UI/ManageOrders.php">MANAGE ORDERS</a></li>
            <li><a href="../staff UI/OrderRecordStaff.php" id="current">ORDER HISTORY</a></li>
            <li><a href="../staff UI/Deliveries.php">DELIVERIES</a></li>
        </ul>
        <div class="account-container">
            <img alt="User Account" class="account-icon" id="accountBtn" src="/images/dropdown_icon.jpg"></img>
            <div class="account-popup" id="accountPopup">
                <ul>
                    <a href="../ManageProfile.php" class="popopt">Manage Profile</a>
                    <a href="../php/EndSession.php" class="popopt">Logout</a>
                </ul>
            </div>
        </div>
    </div>


    <!-- content -->
    <div id="content">
        <h1 id="page_title">ORDER RECORD</h1>
        
        <div class="recordTable">
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Order ID</th>
                        <th>Item ID</th>
                        <th>Item Quantity</th>
                        <th>Order Date</th>
                        <th>Total Price</th>
                        <th>Order Status</th>
                    </tr>
                </thead>
                <tbody id="table_history">

                </tbody>
            </table>
        </div>
    </div>

    

    <div id="footer">
        <div class="flex_center">
            <a href="../ContactInfo.html"><h4>Where to find us</h4></a>
            <a href="../PrivacyPolicy.html"><h4>Privacy Policy</h4></a>
        </div>     
    </div>

    <script src="../js/dropdown.js"></script>
    <script src="../js/orderRecordStaff.js"></script>    
</body>
</html>