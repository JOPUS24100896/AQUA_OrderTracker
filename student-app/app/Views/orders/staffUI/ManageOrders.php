
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
    <style>
        td {
            border: 1px solid black;
        }

        .orderRow:hover{
            cursor: pointer;
        }
    </style>
    <style id="selectRow">
    </style>
</head>
<body>
<?php include "staffHeader.php"?>
<?php if(isset($message)) echo $message?>
    <!-- content -->
    <div id="content">
        <h1 id="page_title" style="display:inline-block;">MANAGE ORDERS</h1>
        <div class="recordTable">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User ID - Name</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Order Date</th>
                        <th>Total Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="table_history">
                    <?php 
                    
                    $iteration = 0; foreach ($data as $dat):
                    ?> 
                    <tr class="orderRow orderNumber<?=$dat['OrderID']?>" onclick="current_select(<?=$dat['OrderID']?>)" data-current-select="0">
                        <td class="orderData OrderId<?=$dat['OrderID']?>" ><?= $dat["OrderID"]?></td>
                        <td class="orderData OrderUser<?=$dat['OrderID']?>"><?= $dat["UserID"]." - ".$dat["FullName"]?></td>
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
        


        <div class="buttoncontainer">
            <button id="pendingButton" disabled>Set to Pending</button>
            
            <button id="readyButton" disabled>Set to Ready</button>
            <!--should only be able to click them when row is selected but idk how to do that-->
        </div>
    </div>

    

            <?= $this->include("orders/footer")?>


    <script src="/js/dropdown.js"></script>
    <script src="/js/manageOrders.js"></script>
    <script src="/js/filterOrdersStaff.js"></script>
</body>
</html>