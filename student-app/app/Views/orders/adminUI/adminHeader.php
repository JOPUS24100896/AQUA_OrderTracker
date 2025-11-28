<!-- <div id="header" class="flex_center">
        <div id="brand_Admin">
            <a href="../index.php"><h1>Aqua Del Sol</h1></a>
        </div>
        <ul id="navbar">
            <li><a href="<?= base_url("orders/admin/orderGraph") ?>" <?php if ($url == "orderGraph") echo 'id = "current"' ?>>ORDER GRAPH</a></li>
            <li><a href="<?= base_url("orders/admin/orderRecord") ?>" <?php if ($url == "orderRecord") echo 'id = "current"' ?>>ORDER RECORD</a></li>
            <li><a href="<?= base_url("orders/admin/inventory") ?>" <?php if ($url == "inventory") echo 'id = "current"' ?>>INVENTORY</a></li>
        </ul>
        <div class="account-container">
            <img alt="User Account" class="account-icon" id="accountBtn" src="/images/dropdown_icon.jpg"></img>
            <div class="account-popup" id="accountPopup">
                <ul>
                    <a href="<?= base_url("orders/manageProf") ?>" class="popopt">Manage Profile</a>
                    <a href="<?= base_url("orders/endSess") ?>" class="popopt">Logout</a>
                </ul>
            </div>
        </div>
    </div> -->

<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background: linear-gradient(to right, #2b607b, #204c55);">
    <div class="container"> <a class="navbar-brand fw-bold fs-2" href="#">Aqua Del Sol</a> <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link <?= ($url == 'orderGraph') ? 'active' : '' ?>"
                        href="<?= base_url('orders/admin/orderGraph') ?>">
                        ORDER GRAPH
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= ($url == 'orderRecord') ? 'active' : '' ?>"
                        href="<?= base_url('orders/admin/orderRecord') ?>">
                        ORDER RECORD
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= ($url == 'inventory') ? 'active' : '' ?>"
                        href="<?= base_url('orders/admin/inventory') ?>">
                        INVENTORY
                    </a>
                </li>

            </ul>
            <div class="account-container"> <img alt="User Account" class="account-icon" id="accountBtn" src="/images/dropdown_icon.jpg"></img>
                <div class="account-popup" id="accountPopup">
                    <ul> <a href="<?= base_url('orders/manageProf') ?>" class="popopt">Profile</a> <a href="<?= base_url('orders/endSess') ?>" class="popopt">Logout</a> </ul>
                </div>
            </div>
        </div>
    </div>
</nav>