<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Record</title>
    <link rel="stylesheet" href="/css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/index.css">
    <script>
        const arr = [];
        <?php foreach ($data as $i): ?>
            arr.push(<?= $i["OrderID"] ?>)
        <?php endforeach; ?>
    </script>
    <style>
        td {
            border: 1px solid black;
        }

        .orderRow:hover {
            cursor: pointer;
        }
    </style>
    <style id="selectRow">
        <?php if (session()->getFlashdata('message')) echo ".orderNumber" . esc(session()->getFlashdata('message')[1]) . "{background-color: #e0f7fa;}" ?>
    </style>
</head>

<body>
    <?php include "staffHeader.php" ?>
    <?php if (isset($message)) echo $message ?>


    <div class="container" style="padding-top: 100px; padding-bottom: 80px;">

        <div class="card shadow rounded-4">
            <div class="card-body" style="min-height: 600px;">
                <h1 class="mb-1 fw-bold text-center">ORDER LIST</h1>

                <?php if (session()->getFlashdata('message')): ?>
                    <div class="alert alert-info">
                        <?= esc(session()->getFlashdata('message')) ?>
                    </div>
                <?php endif; ?>

                <form method="get" class="container mb-3"> <!--  this is the filter    -->
                    <div class="d-flex flex-wrap align-items-end gap-2">
                        <div class="align-items-center gap-2">
                            <label for="item" class="form-label mb-0 small">Filter by:</label>
                            <select name="item" id="item" class="form-select form-select-sm" style="min-width: 200px;" onchange="this.form.submit()">
                                <option value="all" <?= ($itemFilter == 'all' || empty($itemFilter)) ? 'selected' : '' ?>>ALL</option>
                                <option value="Bottled Water" <?= ($itemFilter == 'Bottled Water') ? 'selected' : '' ?>>Bottled Water</option>
                                <option value="Water Gallon" <?= ($itemFilter == 'Water Gallon') ? 'selected' : '' ?>>Water Gallon</option>
                                <option value="Water Gallon With Faucet" <?= ($itemFilter == 'Water Gallon With Faucet') ? 'selected' : '' ?>>With Faucet</option>
                            </select>
                        </div>
                        <div class="ms-auto align-items-center gap-2">
                            <label class="form-label mb-0 small">Search by:</label>
                            <div class="d-flex gap-2">
                                <select name="field" class="form-select form-select-sm" style="min-width: 150px;">
                                    <option value="orders.OrderID" <?= ($searchField == 'orders.OrderID') ? 'selected' : '' ?>>Order ID</option>
                                    <option value="orders.OrderDate" <?= ($searchField == 'orders.OrderDate') ? 'selected' : '' ?>>Order Date</option>
                                </select>

                                <input type="text" name="search"
                                    value="<?= esc($searchValue) ?>"
                                    placeholder="Enter search keyword"
                                    class="form-control form-control-sm"
                                    style="min-width: 200px;">

                                <button type="submit" class="btn btn-primary btn-sm">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
                    <table class="table table-striped table-bordered border-dark table-hover align-middle mb-0">
                        <thead class="table-dark position-sticky top-0">
                            <tr class="text-center">
                                <th>Order Receipt</th>
                                <th>Order Date</th>
                                <th>Customer Name</th>
                                <th>Items</th>
                                <th>Quantities</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th class="col-1">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="table_history" class="text-center">
                            <?php $iteration = 0;
                            foreach ($data as $dat): ?>
                                <tr class="orderRow orderNumber<?= $dat['OrderID'] ?>" onclick="current_select(<?= $dat['OrderID'] ?>)" data-current-select="0">
                                    <td class="orderData OrderId<?= $dat['OrderID'] ?>">
                                        <?php
                                        $receipt = date("Yd", strtotime($dat['OrderDate'])) . $dat['OrderID'];
                                        echo $receipt;
                                        ?>
                                    </td>
                                    <td class="orderData OrderDate<?= $dat["OrderID"] ?>"><?= $dat["OrderDate"] ?></td>
                                    <td class="orderData OrderUser<?= $dat['OrderID'] ?>"><?= $dat["FullName"] ?></td>
                                    <td class="orderData"><?= $dat["ItemID"] . " - " . $dat["ItemName"] ?></td>
                                    <td class="orderData"><?= $dat["ItemQuantity"] ?></td>
                                    <td class="orderData OrderPrice<?= $dat["OrderID"] ?>">₱<?= $dat["TotalPrice"] ?></td>
                                    <td class="orderData OrderStat<?= $dat["OrderID"] ?>"><?= $dat["Status"] ?></td>
                                    <td class="flex-column gap-2 orderData OrderAction<?= $dat["OrderID"] ?>">
                                        <div>
                                            <form class="mb-2" action="<?= base_url("orders/update/orderStatus") ?>" method="post">
                                                <input type="hidden" name="OrderID" value="<?= $dat["OrderID"] ?>">
                                                <button id="pendingButton" name="Status" value="Pending" class="btn btn-warning btn-sm">Set to Pending</button>
                                            </form>
                                            <form action="<?= base_url("orders/update/orderStatus") ?>" method="post">
                                                <input type="hidden" name="OrderID" value="<?= $dat["OrderID"] ?>">
                                                <button id="readyButton" name="Status" value="Ready" class="btn btn-success btn-sm">Set to Ready</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php $iteration++;
                            endforeach; ?>
                            <?php if (empty($data)): ?>
                                <tr>
                                    <td colspan="8" class="text-muted">No orders found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>



    <?= $this->include("orders/footer") ?>

    <form id="form" hidden></form>
    <script src="/js/dropdown.js"></script>
    <script src="/js/manageOrders.js"></script>
    <!-- <script src="/js/filterOrdersStaff.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>