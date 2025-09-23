<div id="header" class="flex_center">
        <div id="brand_Admin">
            <a href="<?=base_url('orders')?>"><h1>Aqua Del Sol</h1></a>
        </div>
        <ul id="navbar">
            <li><a href="<?=base_url('orders/staff/order')?>" <?php if($url == "order") echo 'id = "current"'; ?>>
                MAKE AN ORDER
            </a></li>
            <li><a href="<?=base_url('orders/staff/manageOrders')?>" <?php if($url == "manageOrders") echo 'id = "current"'; ?>>
                MANAGE ORDERS
            </a></li>
            <li><a href="<?=base_url('orders/staff/orderRec')?>" <?php if($url == "orderRec") echo 'id = "current"'; ?>>
                ORDER HISTORY
            </a></li>
            <li><a href="<?=base_url('orders/staff/deliveries')?>" <?php if($url == "deliveries") echo 'id = "current"';?>>
                DELIVERIES
            </a></li>
        </ul>
        <div class="account-container">
            <img alt="User Account" class="account-icon" id="accountBtn" src="/images/dropdown_icon.jpg"></img>
            <div class="account-popup" id="accountPopup">
                <ul>
                    <a href="<?=base_url('orders/manageProf')?>" class="popopt">Manage Profile</a>
                    <a href="<?=base_url('orders/endSess')?>" class="popopt">Logout</a>
                </ul>
            </div>
        </div>
    </div>      