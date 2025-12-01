<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/orderHistory.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/index.css">
    <script>
        let arr = []
        <?php foreach ($data as $dat): ?> arr.push(<?= $dat['OrderID'] ?>);
        <?php endforeach; ?>
    </script>
</head>

<body>
    <?= $this->include("orders/customerUI/custHeader") ?>


    <div id="content" class="container" style="padding-top: 65px; padding-bottom: 100px;">

        <div class="card shadow rounded-4">
            <div class="card-body"  style="min-height: 550px;">
                <h1 class="mb-1 fw-bold text-center">ORDER DETAILS</h1>
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
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-striped table-bordered border-dark table-hover align-middle mb-0">
                        <thead class="table-dark text-center position-sticky top-0">
                            <tr>
                                <th>Order Number</th>
                                <th>Order Date</th>
                                <th>Items</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="table_history" class="text-center">
                            <?php
                            $groupedOrders = [];
                            foreach ($data as $dat) {
                                $id = $dat['OrderID'];
                                if (!isset($groupedOrders[$id])) {
                                    $groupedOrders[$id] = [
                                        'OrderDate' => $dat['OrderDate'],
                                        'Status' => $dat['Status'],
                                        'TotalPrice' => 0,
                                        'Items' => [],
                                        'Quantities' => [],
                                    ];
                                }
                                $groupedOrders[$id]['Items'][] = $dat['ItemName'];
                                $groupedOrders[$id]['Quantities'][] = $dat['ItemQuantity'];
                                $groupedOrders[$id]['Prices'][] = $dat['Price'];
                                $groupedOrders[$id]['TotalPrice'] = $dat['TotalPrice'];
                            }

                            foreach ($groupedOrders as $orderId => $order):
                            ?>
                                <tr class="orderRow">
                                    <td><?= $orderId ?></td>
                                    <td><?= $order['OrderDate'] ?></td>
                                    <td>
                                        <?php foreach ($order['Items'] as $item) echo $item . '<br>'; ?>
                                    </td>
                                    <td>
                                        <?php foreach ($order['Quantities'] as $qty) echo $qty . '<br>'; ?>
                                    </td>
                                    <td>
                                        <?php foreach ($order['Prices'] as $price) echo '₱' . number_format($price, 2) . '<br>'; ?>
                                    </td>
                                    <td>₱<?= number_format($order['TotalPrice']) ?></td>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/dropdown.js"></script>
    <script src="/js/orderHistory.js"></script>
</body>

</html>