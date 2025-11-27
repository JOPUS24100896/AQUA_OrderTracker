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

    <!-- Content -->
    <!-- <div id="content">
        <h1 id="page_title">ORDER HISTORY</h1>
        <div class="HistoryList">
            <table>
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Item Name</th>
                        <th>Price</th>
                        <th>Item Quantity</th>
                        <th>Order Date</th>
                        <th>Total Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="table_history">
                    <?php foreach ($data as $dat): ?>
                        <tr class="orderRow">
                            <td class="orderData OrderID<?= $dat['OrderID'] ?>"><?= $dat['OrderID'] ?></td>
                            <td class="orderData"><?= $dat['ItemName'] ?></td>
                            <td class="orderData"><?= $dat['Price'] ?></td>
                            <td class="orderData"><?= $dat['ItemQuantity'] ?></td>
                            <td class="orderData OrderDate<?= $dat['OrderID'] ?>"><?= $dat['OrderDate'] ?></td>
                            <td class="orderData OrderPrice<?= $dat['OrderID'] ?>"><?= $dat['TotalPrice'] ?></td>
                            <td class="orderData OrderStat<?= $dat['OrderID'] ?>"><?= $dat['Status'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div> -->

    <div id="content" class="container" style="padding-top: 100px; padding-bottom: 400px;">

        <div class="card shadow rounded-4">
            <div class="card-body">

                <h1 class="mb-4 fw-bold text-center">ORDER DETAILS</h1>

                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-striped table-bordered border-dark table-hover align-middle mb-0">
                        <thead class="table-dark text-center position-sticky top-0">
                            <tr>
                                <th>Order Number</th>
                                <th>Items</th>
                                <th>Quantity</th>
                                <th>Order Date</th>
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
                                    <td>
                                        <?php foreach ($order['Items'] as $item) echo $item . '<br>'; ?>
                                    </td>
                                    <td>
                                        <?php foreach ($order['Quantities'] as $qty) echo $qty . '<br>'; ?>
                                    </td>
                                    <td><?= $order['OrderDate'] ?></td>
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