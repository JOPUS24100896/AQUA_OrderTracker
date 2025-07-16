<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
if(!isset($_SESSION["user_id"])){
    header("Location:index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Profile</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/manageProfile.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css">
</head>
<body>
    <div id="header" class="flex_center">
        <div id="brand_Admin">
            <a href="/index.html"><h1>Aqua Del Sol</h1></a>
        </div>
        <ul id="navbar">
            <?php
            switch($_SESSION["user_type"]){
                case "CUST":
                    echo '
                        <li><a href="customer UI/CreateOrder.php">CREATE ORDER</a></li>
                        <li><a href="customer UI/Orders.php">PENDING ORDERS</a></li>
                        <li><a href="customer UI/OrderHistory.php">ORDER HISTORY</a></li>
                    ';
                break;
                case "ADMIN":
                    echo '
                        <li><a href="admin UI/OrderGraph.php">ORDER GRAPH</a></li>
                        <li><a href="admin UI/OrderRecord.php">ORDER RECORD</a></li>
                        <li><a href="admin UI/InventoryUI.php">INVENTORY</a></li>
                    ';
                break;
                case "STAFF":
                    echo '
                        <li><a href="staff UI/MakeAnOrder.php" >MAKE AN ORDER</a></li>
                        <li><a href="staff UI/ManageOrders.php">MANAGE ORDERS</a></li>
                        <li><a href="staff UI/OrderRecordStaff.php">ORDER HISTORY</a></li>
                    ';
                break;
            }
            ?>
        </ul>
        <div class="account-container">
            <img alt="User Account" class="account-icon" id="accountBtn" src="/images/dropdown_icon.jpg"></img>
            <div class="account-popup" id="accountPopup">
                <ul>
                    <a href="ManageProfile.php" class="popopt">Manage Profile</a>
                    <a href="php/EndSession.php" class="popopt">Logout</a>
                </ul>
            </div>
        </div>
    </div>
    <?php
    $id = (int) $_SESSION["user_id"];
    $conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");
    if(!$conn) die("Cannot connect to database: " . mysql_connect_error());
    $query="SELECT * FROM users WHERE UserID = $id";
    if(!($userraw = $conn->query($query))){
        die("There was a problem retrieving user information: " . $conn->errno);
    }
    $user_info = $userraw->fetch_assoc();
    ?>
    <!-- content -->
    <div id="content">
        <h1 id="page_title">MANAGE PROFILE</h1>
        <div class="flex_center">
            <div id="profile">
                <div id="flex">
                    <div class="output_boxes">
                        <p>Fullname: <strong id="outFName">
                            <?php echo $user_info['FullName']?>
                        </strong></p>
                        <p>Address: <strong id="outName">
                            <?php echo $user_info['Address']?>
                        </strong></p>
                        <p>Contact Number: <strong id="outCont">
                            <?php echo (is_null($user_info['Contact']))?'Not Set':$user_info['Contact']?>
                        </strong></p>
                    </div>
                    <div class="output_boxes">
                        <p>Username <strong id="outUName">
                            <?php echo $user_info['Username']?>
                        </strong></p>
                        <p>Email: <strong id="outEmail">
                            <?php echo $user_info['Email']?>
                        </strong></p>
                        <p>Password: <strong id="outPass">***********</strong></p>
                    </div>
                </div>
            </div>
            <div class="container">
                <h2>Edit Profile</h2>
                <form id="profileForm">
                    <div class="flex_center">
                        <div class="input_boxes">
                            <label for="partnerName">FullName:*</label>
                            <input type="text" id="partnerName" name="partnerName" required>

                            <label for="Address">Address:*</label>
                            <input type="text" id="Address" name="Address" required>

                            <label for="contactNumber">Contact Number:*</label>
                            <input type="text" id="contactNumber" name="contactNumber" required>    
                        </div>
                        

                        <div class="input_boxes">
                            <label for="Username">Username:*</label>
                            <input type="text" id="Username" name="Username" required>

                            <label for="partnerEmail">Email:*</label>
                            <input type="email" id="partnerEmail" name="partnerEmail" required>

                            <label for="Password">Password:*</label>
                            <input type="password" id="Password" name="Password" required>
                        </div>
                    </div>
                    <button type="submit">Update Profile</button>
                </form>
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