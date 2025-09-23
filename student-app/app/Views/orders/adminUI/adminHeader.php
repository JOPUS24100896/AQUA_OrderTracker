<div id="header" class="flex_center">
        <div id="brand_Admin">
            <a href="../index.php"><h1>Aqua Del Sol</h1></a>
        </div>
        <ul id="navbar">
            <li><a href="<?=base_url("orders/admin/orderGraph")?>" <?php if($url == "orderGraph") echo 'id = "current"'?>>ORDER GRAPH</a></li>
            <li><a href="<?=base_url("orders/admin/orderRecord")?>" <?php if($url == "orderRecord") echo 'id = "current"'?>>ORDER RECORD</a></li>
            <li><a href="<?=base_url("orders/admin/inventory")?>" <?php if($url == "inventory") echo 'id = "current"'?>>INVENTORY</a></li>
        </ul>
        <div class="account-container">
            <img alt="User Account" class="account-icon" id="accountBtn" src="/images/dropdown_icon.jpg"></img>
            <div class="account-popup" id="accountPopup">
                <ul>
                    <a href="<?=base_url("orders/manageProf")?>" class="popopt">Manage Profile</a>
                    <a href="<?=base_url("orders/endSess")?>" class="popopt">Logout</a>
                </ul>
            </div>
        </div>
    </div>
