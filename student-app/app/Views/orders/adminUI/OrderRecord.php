<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Record</title>
    <link rel="stylesheet" href="/css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/index.css">
</head>

<body>
    <?= $this->include("orders/adminUI/adminHeader") ?>
    <div class="container" style="padding-top: 100px; padding-bottom: 80px">
        <div class="card shadow-lg rounded-4">
            <div class="card-body" style="min-height: 600px;">
                <h1 class="fw-bold text-center mb-1">ORDER RECORD</h1>

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

                    <table class="table table-bordered border-dark table-hover align-middle text-center">
                        <thead class="table-dark position-sticky top-0">
                            <tr>
                                <th>Order Receipt</th>
                                <th>Order Date</th>
                                <th>Item Name</th>
                                <th>Item Quantity</th>
                                <th>Price</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>

                        <tbody id="orderForm">
                            <?php if (!empty($orderRecords)): ?>
                                <?php foreach ($orderRecords as $record): ?>
                                    <tr>
                                        <td>
                                            <?php 
                                            $orderDate = $record['OrderDate'] ?? ''; 
                                            $orderID = $record['ID'] ?? ''; 
                                            echo esc(date("Yd", strtotime($orderDate)) . $orderID); 
                                            ?>
                                        </td>
                                        <td><?= esc($record['OrderDate'] ?? '') ?></td>
                                        <td><?= esc($record['ItemName'] ?? '') ?></td>
                                        <td><?= esc($record['ItemQuantity'] ?? '') ?></td>
                                        <td>₱<?= esc(number_format($record['Price'] ?? 0, 2)) ?></td>
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