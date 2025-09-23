

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Record</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/orderRecordStaff.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const arr = [];
        <?php foreach($data as $i):?>
            arr.push(<?=$i["OrderID"]?>)
        <?php endforeach; ?>
    </script>
</head>
<body>
<?php include "staffHeader.php"?>

    <!-- content -->
    <div id="content">
        <h1 id="page_title">ORDER RECORD</h1>
        
        <div class="recordTable">
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Order ID</th>
                        <th>Item ID</th>
                        <th>Item Quantity</th>
                        <th>Order Date</th>
                        <th>Total Price</th>
                        <th>Order Status</th>
                    </tr>
                </thead>
                <tbody id="table_history">
                    <?php 
                    
                    $iteration = 0; foreach ($data as $dat):
                    ?> 
                    <tr class="orderRow orderNumber<?=$dat['OrderID']?>" onclick="current_select(<?=$dat['OrderID']?>)" data-current-select="0">
                        <td class="orderData OrderUser<?=$dat['OrderID']?>"><?= $dat["UserID"]." - ".$dat["FullName"]?></td>    
                        <td class="orderData OrderId<?=$dat['OrderID']?>" ><?= $dat["OrderID"]?></td>
                        <td class="orderData"><?= $dat["ItemID"]." - ".$dat["ItemName"]?></td>
                        <td class="orderData"><?= $dat["ItemQuantity"]?></td>
                        <td class="orderData OrderDate<?= $dat["OrderID"]?>"><?= $dat["OrderDate"]?></td>
                        <td class="orderData OrderPrice<?= $dat["OrderID"]?>"><?= $dat["TotalPrice"]?></td>
                        <td class="orderData OrderStat<?= $dat["OrderID"]?>"><?= $dat["Status"]?></td>
                    </tr>
                    <?php $iteration++; endforeach;?>
                </tbody>
            </table>
        </div>
    </div>

    

            <?= $this->include("orders/footer")?>

    <script src="/js/manageOrders.js"></script>
    <script src="/js/dropdown.js"></script>
    <script src="/js/orderRecordStaff.js"></script> 
</body>
</html>