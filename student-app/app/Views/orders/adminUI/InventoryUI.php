<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link rel="stylesheet" href="/css/main.css">
    <!-- <link rel="stylesheet" href="/css/inventory.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/index.css">
</head>

<body>

    <?= $this->include("orders/adminUI/adminHeader") ?>

    <!-- <div id="content">
        <h1 id="page_title">INVENTORY</h1>
        <div id="InventoryTable">
            <table>
                <thead>
                    <div id="header_background"></div>
                    <tr id="table_header">    
                        <th>ID</th>
                        <th>Product Image</th>
                        <th>Name</th>
                        <th>Items in Stock</th>
                        <th>Add Stock</th>
                    </tr>
                </thead>
                <tbody id="orderForm">
                <?php if (!empty($Inventory)): ?>
                    <?php foreach ($Inventory as $item): ?>
                        <tr>
                            <td><?= esc($item['ItemID']) ?></td>
                            <td class="productCard" loading="lazy">
                                <img src="/uploads/<?= $item['ImagePath'] ?>" style='height: 115px;'
                                alt="Product Image" />
                            </td>
                            <td ><?= esc($item['ItemName']) ?></td>
                             <td><?= esc($item['StockQuantity']) ?></td>
                            <td class="inputBox">
                                <input type="number" min="1" id="stock-<?= esc($item['ItemID']) ?>">
                                <button type="button" onclick="updateStock(<?= esc($item['ItemID']) ?>)">ADD</button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php else: ?>
                    <tr><td colspan="5">No inventory found.</td></tr>
                <?php endif ?>
                </tbody>
            </table>
        </div>
    </div> -->

    <div class="container" style="padding-top: 80px; padding-bottom: 80px">
        <div class="container mt-3" id="messageBox"></div>
        <div class="card shadow-lg rounded-4">
            <div class="card-body">
                <h1 class="text-center fw-bold mb-4">INVENTORY</h1>
                <div id="InventoryTable" class="table-responsive">
                    <table class="table table-striped table-bordered border-dark align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Product Image</th>
                                <th>Name</th>
                                <th>Items in Stock</th>
                                <th>Add Stock</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($Inventory)): ?>
                                <?php foreach ($Inventory as $item): ?>
                                    <tr>
                                        <td><?= esc($item['ItemID']) ?></td>

                                        <td>
                                            <img src="/uploads/<?= $item['ImagePath'] ?>"
                                                class="img-fluid rounded shadow-sm border"
                                                style="height: 120px; object-fit: cover; border-color:#444!important;">
                                        </td>

                                        <td><?= esc($item['ItemName']) ?></td>

                                        <td>
                                            <span class="badge bg-secondary text-light fs-6 px-3 py-2"
                                                style="border:1px solid #444;">
                                                <?= esc($item['StockQuantity']) ?>
                                            </span>
                                        </td>


                                        <td>
                                            <div class="d-flex justify-content-center gap-2">

                                                <input type="number" min="1"
                                                    id="stock-<?= esc($item['ItemID']) ?>"
                                                    class="form-control form-control-sm border-dark"
                                                    style="width: 90px;">

                                                <button type="button"
                                                    class="btn btn-outline-dark btn-sm px-3"
                                                    onclick="updateStock(<?= esc($item['ItemID']) ?>)">
                                                    Add
                                                </button>

                                            </div>
                                        </td>

                                    </tr>
                                <?php endforeach ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-muted">No inventory found.</td>
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
    <script>
        function updateStock(itemId) {
            const input = document.getElementById(`stock-${itemId}`);
            const addedStock = parseInt(input.value);

            if (!addedStock || addedStock <= 0) {
                showMessage("Please enter a valid stock quantity.", "danger");
                return;
            }

            fetch('/api/add-stock', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        ItemID: itemId,
                        AddedStock: addedStock
                    })
                })
                .then(response => response.json())
                .then(data => {
                    showMessage(data.message, "success");
                    setTimeout(() => location.reload(), 1200);
                })
                .catch(error => {
                    showMessage("Error updating stock.", "danger");
                    console.error('Error updating stock:', error);
                });
        }

        function showMessage(message, type = "success") {
            const box = document.getElementById("messageBox");
            box.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show shadow" role="alert">
            <strong>${message}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>