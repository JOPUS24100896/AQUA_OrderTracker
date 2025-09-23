
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/orderHistory.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css">
</head> 

<body>
    <?= $this->include("orders/customerUI/custHeader")?>

    <!-- Content -->
    <div id="content">
        <h1 id="page_title">ORDER HISTORY</h1>
        <div class="HistoryList">
            <table>
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Item Name</th>
                        <th>Item Quantity</th>
                        <th>Price</th>
                        <th>Order Date</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody id="table_history">
                    <?php foreach($data as $dat): ?>
                        <tr class="orderRow">
                            <td class="orderData OrderID<?= $dat['OrderID']?>"><?= $dat['OrderID']?></td>
                            <td class="orderData"><?= $dat['ItemName']?></td>
                            <td class="orderData"><?= $dat['ItemQuantity']?></td>
                            <td class="orderData"><?= $dat['Price']?></td>
                            <td class="orderData OrderDate<?= $dat['OrderID']?>"><?= $dat['OrderDate']?></td>
                            <td class="orderData OrderPrice<?= $dat['OrderID']?>"><?= $dat['TotalPrice']?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>

    </div>

    <?= $this->include("orders/footer")?>


    <script src="/js/dropdown.js"></script>
    <script src="/js/orderHistory.js"></script>
</body>

</html>