<?php
include "../php/cust_auth.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/orders.css">
    <link rel="stylesheet" href="../css/orderHistory.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css">

    <style id="selectRow"></style>
</head>

<body>
    <div id="header" class="flex_center">
        <div id="brand_Admin">
            <a href="../index.php"><h1>Aqua Del Sol</h1></a>
        </div>
        <ul id="navbar">
            <li><a href="CreateOrder.php">CREATE ORDER</a></li>
            <li><a href="Orders.php" id="current">PENDING ORDERS</a></li>
            <li><a href="OrderHistory.php">ORDER HISTORY</a></li>
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

    <!-- Content -->
    <div id="content">
        <h1 id="page_title">PENDING ORDERS</h1>
        <div class="OrderList">
            <table>
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Item Name</th>
                        <th>Price</th>
                        <th>Order Date</th>
                        <th>TotalPrice</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="table_history">

                </tbody>
            </table>
        </div>
        <div class="buttoncontainer">
            <button id="cancelOrderButton" hidden>Cancel Order</button>
            <label for ="cancelButton" id="confirmPrompt" hidden> 
                <span style="color:white;">
                    <h3>Are you sure you want to cancel your order?<h3>
                </span>
                <button id="cancelYesButton" >Yes</button>
                <button id="cancelNoButton" >No</button>
            </label>
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
    <script src="../js/pendingOrder.js"></script>
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