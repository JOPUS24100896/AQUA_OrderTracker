<?php
include "../php/admin_auth.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Record</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/trend.css">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script> -->
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="/js/graphFunction.js"></script>
</head>
<body>
    <div id="header" class="flex_center">
        <div id="brand_Admin">
            <a href="../index.php"><h1>Aqua Del Sol</h1></a>
        </div>
        <ul id="navbar">
            <li><a href="OrderGraph.php"  id="current">ORDER GRAPH</a></li>
            <li><a href="OrderRecord.php">ORDER RECORD</a></li>
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

    <div id="content">
        <h1 id="page_title">ORDER TREND</h1>
        <div id="salesChartContainer" class="flex_center">
          <div id="myChart" style="  width: 50vw; height: 50vh; border-radius: 20px;"></div>
          <div id="salesLegend">
          </div>          
        </div>
    </div>
    
    
    
    <div id="footer">
        <div class="flex_center">
            <a href="/ContactInfo.html"><h4>Where to find us</h4></a>
            <a href="/PrivacyPolicy.html"><h4>Privacy Policy</h4></a>
        </div>     
    </div>

  
  <script src="/js/dropdown.js"></script>
</body>
</html>