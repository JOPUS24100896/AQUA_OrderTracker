<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    <link rel="stylesheet" href="/css/main.css">
    <!-- <link rel="stylesheet" href="/css/orders.css">
    <link rel="stylesheet" href="/css/orderHistory.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/index.css">
    <style id="selectRow"></style>
    <script>
        const arr = [];
        <?php foreach ($data as $dat): ?> arr.push(<?= $dat['OrderID'] ?>);
        <?php endforeach; ?>
    </script>
</head>

<body>
    <?= $this->include("orders/customerUI/custHeader") ?>
    <div id="content" class="container" style="padding-top: 65px; padding-bottom: 100px;">

        <div class="card shadow rounded-4">
            <div class="card-body"  style="min-height: 550px;">

                <h1 class="mb-4 fw-bold text-center">ORDER DETAILS</h1>

                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-striped table-bordered border-dark table-hover align-middle mb-0">
                        <thead class="table-dark text-center position-sticky top-0">
                            <tr>
                                <th>Order Receipt</th>
                                <th>Order Date</th>
                                <th>Items</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Action</th>
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
                                    <td>
                                        <?php
                                        $receipt = date("Yd", strtotime($order['OrderDate'])) . $orderId;
                                        echo $receipt;
                                        ?>
                                    </td>
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
                                    <td>
                                        <form method="post" action="<?= base_url('orders/cust/cancelOrder') ?>">
                                            <input type="hidden" name="OrderID" value="<?= $orderId ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <?= $this->include("orders/footer") ?>

    <script src="/js/dropdown.js"></script>
    <script src="/js/pendingOrder.js"></script>
    <script>
        document.querySelectorAll('.ProductCard').forEach(card => {
            const minus = card.querySelector('button:first-child');
            const plus = card.querySelector('button:last-child');
            const count = card.querySelector('span');

            minus.addEventListener('click', () => {
                let val = parseInt(count.textContent);
                if (val > 0) count.textContent = val - 1;
            });

            plus.addEventListener('click', () => {
                let val = parseInt(count.textContent);
                count.textContent = val + 1;
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>