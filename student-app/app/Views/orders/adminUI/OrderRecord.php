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
            <div class="card-body">
                <h1 class="fw-bold text-center mb-4">ORDER RECORD</h1>
                
                <form method="get"> <!--  this is the filter            -->
                    <label for="item">Filter by:</label>
                    <select name="item" id="item" onchange="this.form.submit()">
                        <option value="all" <?= ($itemFilter == 'all' || empty($itemFilter)) ? 'selected' : '' ?>>ALL</option>
                        <option value="Bottled Water" <?= ($itemFilter == 'Bottled Water') ? 'selected' : '' ?>>Bottled Water</option>
                        <option value="Water Gallon" <?= ($itemFilter == 'Water Gallon') ? 'selected' : '' ?>>Water Gallon</option>
                        <option value="Water Gallon With Faucet" <?= ($itemFilter == 'Water Gallon With Faucet') ? 'selected' : '' ?>>With Faucet</option>
                    </select>
                </form>



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