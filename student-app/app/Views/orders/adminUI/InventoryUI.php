
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="/css/inventory.css">
</head>
<body>
    <?= $this->include("orders/adminUI/adminHeader")?>

    <div id="content">
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
                                <img src="/uploads/<?= $item['ImagePath']?>" style='height: 115px;'
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
    </div>

    
    <?= $this->include("orders/footer")?>

    <script src="/js/dropdown.js"></script>
    <script>
        function updateStock(itemId) {
            const input = document.getElementById(`stock-${itemId}`);
            const addedStock = parseInt(input.value);

            if (!addedStock || addedStock <= 0) {
                alert("Please enter a valid stock quantity.");
                return;
            }

            fetch('/api/add-stock', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ ItemID: itemId, AddedStock: addedStock })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                location.reload();
            })
            .catch(error => {
                console.error('Error updating stock:', error);
            });
        }

    </script>
</body>
</html>