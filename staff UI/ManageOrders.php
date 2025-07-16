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
    <style>
        td {
            border: 1px solid black;
        }

        .orderRow:hover{
            cursor: pointer;
        }
    </style>
    <style id="selectRow">
    </style>
</head>
<body>
    <div id="header" class="flex_center">
        <div id="brand_Admin">
            <a href="../index.php"><h1>Aqua Del Sol</h1></a>
        </div>
        <ul id="navbar">
            <li><a href="../staff UI/MakeAnOrder.php" >MAKE AN ORDER</a></li>
            <li><a href="../staff UI/ManageOrders.php" id="current">MANAGE ORDERS</a></li>
            <li><a href="../staff UI/OrderRecordStaff.php">ORDER HISTORY</a></li>
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
        <h1 id="page_title" style="display:inline-block;">MANAGE ORDERS</h1>
        <label for="dropdown" style="color: white;">Filter By:</label>
        <select id="dropdown" name="type">
            <option value="Order ID">Order ID</option>
            <option value="User ID">User ID</option>
            <option value="Name">Name</option>
            <option value="Status">Status</option>
        </select>
        <label style="color: white;">Enter Filter Value<input id="dropButton" value="" type="text"></label>
        <label id="dropdownStat" style="color: white;" >
            Enter Filter Value
            <select name="type" title="Select Status Value">
                <option value="Order ID">Ready</option>
                <option value="User ID">Pending</option>
            </select>
        </label>
        
        <div class="recordTable">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User ID - Name</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Order Date</th>
                        <th>Total Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="table_history">

                </tbody>
            </table>
        </div>
        <div class="buttoncontainer">
            <button id="pendingButton" disabled>Set to Pending</button>
            
            <button id="readyButton" disabled>Set to Ready</button>
            <!--should only be able to click them when row is selected but idk how to do that-->
        </div>
    </div>

    

    <div id="footer">
        <div class="flex_center">
            <a href="../ContactInfo.html"><h4>Where to find us</h4></a>
            <a href="../PrivacyPolicy.html"><h4>Privacy Policy</h4></a>
        </div>     
    </div>

    <script src="../js/dropdown.js"></script>
    <script src="../js/manageOrders.js"></script>    
    <script src="../js/filterOrdersStaff.js"></script>
</body>
</html>