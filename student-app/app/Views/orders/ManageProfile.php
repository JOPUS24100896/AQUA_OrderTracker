
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
    <?php
    if(isset($_SESSION["user_id"])){
        switch($_SESSION["user_type"]){
            case "STAFF":
                echo $this->include("orders/staffUI/staffHeader");
            break;
            case "CUST":
                echo $this->include("orders/customerUI/custHeader");
            break;
            case "ADMIN":
                echo $this->include("orders/adminUI/adminHeader");
            break;
        }
    }
    ?>
    <!--
    <div id="header" class="flex_center">
        <div id="brand_Admin">
            <a href="/index.html"><h1>Aqua Del Sol</h1></a>
        </div>
        <ul id="navbar">
            <?php
            // switch($_SESSION["user_type"]){
            //     case "CUST":
            //         echo '
            //             <li><a href="customer UI/CreateOrder.php">CREATE ORDER</a></li>
            //             <li><a href="customer UI/Orders.php">PENDING ORDERS</a></li>
            //             <li><a href="customer UI/OrderHistory.php">ORDER HISTORY</a></li>
            //         ';
            //     break;
            //     case "ADMIN":
            //         echo '
            //             <li><a href="admin UI/OrderGraph.php">ORDER GRAPH</a></li>
            //             <li><a href="admin UI/OrderRecord.php">ORDER RECORD</a></li>
            //             <li><a href="admin UI/InventoryUI.php">INVENTORY</a></li>
            //         ';
            //     break;
            //     case "STAFF":
            //         echo '
            //             <li><a href="staff UI/MakeAnOrder.php" >MAKE AN ORDER</a></li>
            //             <li><a href="staff UI/ManageOrders.php">MANAGE ORDERS</a></li>
            //             <li><a href="staff UI/OrderRecordStaff.php">ORDER HISTORY</a></li>
            //             <li><a href="staff UI/Deliveries.php">DELIVERIES</a></li>
            //         ';
            //     break;
            // }
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
        -->
            <div class="container">
                <form id="profileForm">
                    <h2>Edit Profile</h2>
                    <div class="flex_center">
                        

                        <div class="input_boxes">
                            <label for="partnerName">Full Name <span style="color: red;">*</span></label>
                            <input type="text" name="partnerName" required>

                            <label for="Address">Address <span style="color: red;">*</span></label>
                            <input type="text" name="Address" required>

                            <label for="contactNumber">Contact Number <span style="color: red;">*</span></label>
                            <input type="text" name="contactNumber" required>    
                        </div>
                        

                        <div class="input_boxes">
                            <label for="Username">Username <span style="color: red;">*</span></label>
                            <input type="text" id="Username" name="Username" required>

                            <label for="partnerEmail">Email <span style="color: red;">*</span></label>
                            <input type="email" id="partnerEmail" name="partnerEmail" required>

                            <label for="Password">Password <span style="color: red;">*</span></label>
                            <input type="password" id="Password" name="UpdatePassword" required>
                        </div>
                    </div>
                    
                    <button type="submit">Update Profile</button>
                </form>
                <div id="verifyDiv" hidden>
                    <form id="verifyForm">
                        <h2>User Verification</h2>
                        <div class="flex_center">
                            <div class="input_boxes">
                                <label for="verifyPass">Enter Current Password <span style="color: red;">*</span></label><br>
                                <input type="password" id="verifPass" name="password" required>    
                                <span style="color: red;" id="errFeedback"></span>
                            </div>   
                        </div>
                        <button type="submit">Update</button>
                    </form>   
                    <button id="backForm">Back</button>
                </div>
            </div>
        </div>
    </div>
            <?= $this->include("orders/footer")?>


    <script src="/js/dropdown.js"></script>
    <script src="js/manageProfile_form.js"></script>
</body>
</html>