<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Record</title>
    <link rel="stylesheet" href="/css/main.css">
    <!-- <link rel="stylesheet" href="/css/orderrecord.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/index.css">
</head>

<body>
    <?= $this->include("orders/adminUI/adminHeader") ?>

    <!-- content -->
    <!-- <div id="content">
        <h1 id="page_title">ORDER RECORD</h1>
        <div id="OrderRecordTable">
            <table>
                <thead>
                    <div id="header_background"></div>
                    <tr id="table_header">    
                        <th>ID</th>
                        <th>ItemName</th>
                        <th>ItemQuantity</th>
                        <th>Price</th>
                        <th>OrderDate</th>
                        <th>TotalPrice</th>
                    </tr>
                </thead>
                <tbody id="orderForm">
                <?php if (!empty($orderRecords)): ?>
                    <?php foreach ($orderRecords as $record): ?>
                        <tr>
                            <td><?= esc($record['ID'] ?? '') ?></td>
                            <td><?= esc($record['ItemName'] ?? '') ?></td>
                            <td><?= esc($record['ItemQuantity'] ?? '') ?></td>
                            <td><?= esc($record['Price'] ?? '') ?></td>
                            <td><?= esc($record['OrderDate'] ?? '') ?></td>
                            <td><?= esc($record['TotalPrice'] ?? '') ?></td>
                        </tr>
                    <?php endforeach ?>
                <?php else: ?>
                    <tr><td colspan="6">No orders found.</td></tr>
                <?php endif ?>
                </tbody>
            </table>
        </div> 
    </div> -->

    <div class="container" style="padding-top: 100px; padding-bottom: 80px">
        <div class="card shadow-lg rounded-4">
            <div class="card-body">
                <h1 class="fw-bold text-center mb-4">ORDER RECORD</h1>

                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">

                    <table class="table table-bordered border-dark table-hover align-middle text-center">
                        <thead class="table-dark position-sticky top-0">
                            <tr>
                                <th>ID</th>
                                <th>Item Name</th>
                                <th>Item Quantity</th>
                                <th>Price</th>
                                <th>Order Date</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>

                        <tbody id="orderForm">
                            <?php if (!empty($orderRecords)): ?>
                                <?php foreach ($orderRecords as $record): ?>
                                    <tr>
                                        <td><?= esc($record['ID'] ?? '') ?></td>
                                        <td><?= esc($record['ItemName'] ?? '') ?></td>
                                        <td><?= esc($record['ItemQuantity'] ?? '') ?></td>
                                        <td>₱<?= esc(number_format($record['Price'] ?? 0, 2)) ?></td>
                                        <td><?= esc($record['OrderDate'] ?? '') ?></td>
                                        <td>₱<?= esc(number_format($record['TotalPrice'] ?? 0, 2)) ?></td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-muted">No orders found.</td>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <?= $this->include("orders/footer") ?>

    <script src="/js/dropdown.js"></script>
    <script src="/js/orderRecord.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>