<div id="header" class="flex_center">
        <div id="brand_Admin">
           <a href="../index.php"><h1>Aqua Del Sol</h1></a>
        </div>
        <ul id="navbar">
            <li><a href="<?= base_url("orders/cust/order")?>" <?php if($url == "order") echo 'id = "current"'; ?>>CREATE ORDER</a></li>
            <li><a href="<?= base_url("orders/cust/pending")?>" <?php if($url == "pending") echo 'id = "current"'; ?>>PENDING ORDERS</a></li>
            <li><a href="<?= base_url("orders/cust/history")?>" <?php if($url == "history") echo 'id = "current"'; ?>>ORDER HISTORY</a></li>
        </ul>
        <div class="account-container">
            <img alt="User Account" class="account-icon" id="accountBtn" src="/images/dropdown_icon.jpg"></img>
            <div class="account-popup" id="accountPopup">
                <ul>
                    <a href="<?= base_url("orders/manageProf")?>" class="popopt">Manage Profile</a>
                    <a href="<?= base_url("orders/endSess")?>" class="popopt">Logout</a>
                </ul>
            </div>
        </div>
    </div>