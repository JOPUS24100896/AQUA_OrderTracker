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
</head>

<body>
    <?php include "staffHeader.php" ?>

    <!-- content -->
    <div class="container mt-4 mb-4" style="padding-top: 100px; padding-bottom: 300px;">
        <div class="card shadow rounded-4">
            <div class="card-body">
                <h1 class="mb-4 fw-bold text-center">ORDER RECORD</h1>
                 <form method="get"> <!--  this is the filter            -->
                    <label for="item">Search by:</label>
                    <select name="field">
                        <option value="orders.OrderID" <?= ($searchField == 'orders.OrderID') ? 'selected' : '' ?>>Order ID</option>
                        <option value="orders.OrderDate" <?= ($searchField == 'orders.OrderDate') ? 'selected' : '' ?>>Order Date</option>
                    </select>
                    <input type="text" name="search" value="<?= esc($searchValue) ?>" placeholder="Enter search keyword">
                    <button type="submit">Search</button>

                    <label for="item">Filter by:</label>
                    <select name="item" id="item" onchange="this.form.submit()">
                        <option value="all" <?= ($itemFilter == 'all' || empty($itemFilter)) ? 'selected' : '' ?>>ALL</option>
                        <option value="Bottled Water" <?= ($itemFilter == 'Bottled Water') ? 'selected' : '' ?>>Bottled Water</option>
                        <option value="Water Gallon" <?= ($itemFilter == 'Water Gallon') ? 'selected' : '' ?>>Water Gallon</option>
                        <option value="Water Gallon With Faucet" <?= ($itemFilter == 'Water Gallon With Faucet') ? 'selected' : '' ?>>With Faucet</option>
                    </select>

                </form>
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-striped table-bordered border-dark table-hover align-middle mb-0">
                        <thead class="table-dark position-sticky top-0">
                            <tr class="text-center">
                                <th>User ID - Name</th>
                                <th>Order ID</th>
                                <th>Items</th>
                                <th>Quantities</th>
                                <th>Order Date</th>
                                <th>Total Price</th>
                                <th>Order Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            $groupedOrders = [];
                            foreach ($data as $dat) {
                                $id = $dat['OrderID'];
                                if (!isset($groupedOrders[$id])) {
                                    $groupedOrders[$id] = [
                                        'User' => $dat['UserID'] . ' - ' . $dat['FullName'],
                                        'OrderDate' => $dat['OrderDate'],
                                        'Status' => $dat['Status'],
                                        'TotalPrice' => 0,
                                        'Items' => [],
                                        'Quantities' => []
                                    ];
                                }
                                $groupedOrders[$id]['Items'][] = $dat['ItemID'] . ' - ' . $dat['ItemName'];
                                $groupedOrders[$id]['Quantities'][] = $dat['ItemQuantity'];
                                $groupedOrders[$id]['TotalPrice'] = $dat['TotalPrice'];
                            }

                            foreach ($groupedOrders as $orderID => $order):
                            ?>
                                <tr>
                                    <td><?= $order['User'] ?></td>
                                    <td><?= $orderID ?></td>
                                    <td>
                                        <?php foreach ($order['Items'] as $item) echo $item . '<br>'; ?>
                                    </td>
                                    <td>
                                        <?php foreach ($order['Quantities'] as $qty) echo $qty . '<br>'; ?>
                                    </td>
                                    <td><?= $order['OrderDate'] ?></td>
                                    <td>₱<?= number_format($order['TotalPrice'], 2) ?></td>
                                    <td><?= $order['Status'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <?= $this->include("orders/footer") ?>

    <script src="/js/manageOrders.js"></script>
    <script src="/js/dropdown.js"></script>
    <script src="/js/orderRecordStaff.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>