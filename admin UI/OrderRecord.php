<?php
include "../php/admin_auth.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Record</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/orderrecord.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div id="header" class="flex_center">
        <div id="brand_Admin">
            <a href="../index.php"><h1>Aqua Del Sol</h1></a>
        </div>
        <ul id="navbar">
            <li><a href="OrderGraph.php">ORDER GRAPH</a></li>
            <li><a href="OrderRecord.php"  id="current">ORDER RECORD</a></li>
            <li><a href="InventoryUI.php">INVENTORY</a></li>
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
        <!-- <div id="search_container">
        <input type="text" id="myInput" onkeyup="searchFunction()" placeholder="Search for names.."></div> -->
        
        <div id="OrderRecordTable">
            <table>
                <thead>
                    <div id="header_background"></div>
                    <tr id="table_header">    
                        <!-- <th id="order_id">ID</th>
                        <th id="customer_name">Customer Name</th>
                        <th id="order_date">Order Date</th>
                        <th id="amount">Amount</th> -->
                        <th>ID</th>
                        <th>ItemName</th>
                        <th>ItemQuantity</th>
                        <th>Unit Price</th>
                        <th>OrderDate</th>
                        <th>TotalPrice</th>
                    </tr>
                </thead>
                <tbody id="orderForm">
                   
                </tbody>
            </table>
        </div>
        
    </div>

    

    <div id="footer">
        <div class="flex_center">
            <a href="/ContactInfo.html"><h4>Where to find us</h4></a>
            <a href="/PrivacyPolicy.html"><h4>Privacy Policy</h4></a>
        </div>     
    </div>

    <script src="/js/dropdown.js"></script>
    <script src="/js/orderRecord.js"></script>    
</body>
</html>