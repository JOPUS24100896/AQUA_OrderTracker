
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
                </tbody>
            </table>
        </div>
    </div>

    
    <?= $this->include("orders/footer")?>

    <script src="/js/dropdown.js"></script>
    <script src="/js/inventory_list.js"></script>
</body>
</html>