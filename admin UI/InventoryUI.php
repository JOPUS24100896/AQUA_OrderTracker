<?php
include "../php/admin_auth.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="../css/inventory.css">
</head>
<body>
    <div id="header" class="flex_center">
        <div id="brand_Admin">
            <a href="../index.php"><h1>Aqua Del Sol</h1></a>
        </div>
        <ul id="navbar">
            <li><a href="OrderGraph.php">ORDER GRAPH</a></li>
            <li><a href="OrderRecord.php">ORDER RECORD</a></li>
            <li><a href="InventoryUI.php" id="current">INVENTORY</a></li>
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

    <div id="content">
        <h1 id="page_title">INVENTORY</h1>
        <div id="InventoryTable">
            <table>
                <thead>
                    <div id="header_background"></div>
                    <tr id="table_header">    
                        <th>ID</th>
                        <th>Product Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Items in Stock</th>
                        <th>Add Stock</th>
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
    <script src="/js/inventory_list.js"></script>
</body>
</html>