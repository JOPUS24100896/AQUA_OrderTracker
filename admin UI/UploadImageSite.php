<?php
include "../php/admin_auth.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/uploadSite.css">
</head>
<body>
    <div id="header" class="flex_center">
        <div id="brand_Admin">
            <a href="../index.php"><h1>Aqua Del Sol</h1></a>
        </div>
        <ul id="navbar">
            <li><a href="OrderGraph.php">ORDER GRAPH</a></li>
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

    <form action="uploadImage.php" method="post" enctype="multipart/form-data">
        <h2>Upload Image</h2>
        <label class="label">Select Image File:</label>
        <input class="submit" type="file" name="image" required>
        <label class="label">Enter ID</label>
        <input id="inputId" type="text" name="id" required>
        <label for="dropdown" class="label">Choose an option:</label>
        <select id="dropdown" name="type">
            <option value="jpeg">jpeg</option>
            <option value="png">png</option>
            <option value="webp">webp</option>
        </select>
        <input id="submit" class="submit" type="submit" name="submit" value="Upload">
    </form>

    <div id="footer">
        <div class="flex_center">
            <a href="/ContactInfo.html"><h4>Where to find us</h4></a>
            <a href="/PrivacyPolicy.html"><h4>Privacy Policy</h4></a>
        </div>     
    </div>

    <script src="/js/dropdown.js"></script>
<!--<img src="viewImage.php?id=1">-->
</body>
</html>