

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Record</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/orderRecordStaff.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-info">
        <?= esc(session()->getFlashdata('message')) ?>
    </div>
<?php endif; ?>

<?php include "staffHeader.php"?>
    <!-- content -->
    <div id="content">
        <h1 id="page_title" style="display:inline-block;">DELIVERIES</h1>
        <div class="recordTable">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User ID - Name</th>
                        <th>Order Date</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Vehicle ID - Number</th>
                    </tr>
                </thead>
                <tbody id="table_history">
                    <?php foreach($data as $row):?>
                        <tr class="orderRow orderNumber<?= $row['OrderID']?>" onclick="current_select(<?= $row['OrderID']?>,<?= $row['DeliveryID']?>)" data-current-select="0">
                            <td class="orderData"><?= $row['OrderID']?></td>
                            <td class="orderData"><?= $row['UserID']." - ".$row["Username"]?></td>
                            <td class="orderData"><?= $row['OrderDate']?></td>
                            <td class="orderData"><?= $row['TotalPrice']?></td>
                            <td class="orderData"><?= $row['DeliveryStatus']?></td>   
                            <td class="orderData">
                                <?php 
                                    if(is_null($row['PortID'])) 
                                        echo "Not Set" ;
                                    else echo $row['PortID'];
                                    echo " - ";
                                    if(is_null($row['PortNumber'])) 
                                        echo "Not Set" ;
                                    else echo $row['PortNumber'];
                                ?>

                            </td>   
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <div class="buttoncontainer">
            <form style="display: inline-block;" action="<?=base_url('orders/update/delivery')?>" method="post">
                <input type="hidden" name="DeliveryID" value="" id="pend">
                <button id="pendingButton" value="Pending" name="Status" disabled>Set to Pending</button>
            </form>

            <form style="display: inline-block;" action="<?=base_url('orders/update/delivery')?>" method="post">
                <input type="hidden" name="DeliveryID" value="" id="dev">
                <button id="delivButton" value="Delivered" name="Status" disabled>Set to Delivered</button>
            </form>

            
            
            <form style="display: inline-block;" action="<?=base_url('orders/update/delivery')?>" method="post">
                <input type="hidden" name="DeliveryID" value="" id="port">
                <select title="Assign to Vehicle" id="portSelect" name="PortID" disabled>
                    <option disabled selected value="null">Select Port</option>
                    <option value="0">None</option>
                <?php
                    $conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");

                    if($ports = $conn->query("SELECT * FROM delivery_port")){
                        while($ports_row = $ports->fetch_assoc()){
                            echo "<option value='". $ports_row["PortID"] ."'>".$ports_row["PortNumber"]."</option>";
                        }
                    }
                ?>
                </select>
                <button id="portButton" disabled>Assign Vehicle</button>
            </form>
                
            
        </div>
    </div>

    <?= $this->include("orders/footer")?>


    <script src="/js/dropdown.js"></script>
    <script src="/js/deliveries.js"></script> 
    <script src="/js/filterOrdersStaff.js"></script>
</body>
</html>