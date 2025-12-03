<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Record</title>
    <link rel="stylesheet" href="/css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/index.css">
    <style>
        td {
            border: 1px solid black;
        }

        .orderRow:hover {
            cursor: pointer;
        }
    </style>
    <style id="selectRow">
        <?php if (session()->getFlashdata('message')) echo esc(session()->getFlashdata('message')[1]) ?>
    </style>
</head>

<body>


    <?php include "staffHeader.php" ?>
    
    <div class="container" style="padding-top: 100px; padding-bottom: 80px;">

        <div class="card shadow rounded-4">
            <div class="card-body" style="min-height: 600px;">
                <h1 class="mb-4 fw-bold text-center">DELIVERIES</h1>
                <?php if (session()->getFlashdata('message')): ?>
                    <div class="alert alert-info">
                        <?= esc(session()->getFlashdata('message')[0]) ?>
                    </div>
                <?php endif; ?>

                <style id="selectRow"></style>

                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-striped table-bordered border-dark table-hover align-middle mb-0">
                        <thead class="table-dark position-sticky top-0">
                            <tr class="text-center">
                                <th>Select</th>
                                <th>Order Receipt</th>
                                <th>Order Date</th>
                                <th>User Name</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Vehicle ID - Number</th>
                            </tr>
                        </thead>
                        <tbody id="table_history">
                            <?php foreach ($data as $row): ?>
                                <tr class="orderRow text-center orderNumber<?= $row['DeliveryID'] ?>" data-current-select="0">
                                    <td class="text-center">
                                        <div class="form-check d-flex justify-content-center">
                                            <input class="form-check-input selectCheckbox" type="checkbox"
                                                id="select-<?= $row['OrderID'] ?>"
                                                onclick="current_select(<?= $row['OrderID'] ?>, <?= $row['DeliveryID'] ?>, this)" style="transform: scale(1.3);">
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                        $receipt = date("Yd", strtotime($row['OrderDate'])) . $row['OrderID'];
                                        echo $receipt;
                                        ?>
                                    </td>
                                    <td><?= $row['OrderDate'] ?></td>
                                    <td><?= $row["FullName"] ?></td>
                                    <td>₱<?= number_format($row['TotalPrice'], 2) ?></td>
                                    <td><?= $row['DeliveryStatus'] ?></td>
                                    <td>
                                        <?php
                                        if (is_null($row['PortID'])) echo "Not Set";
                                        else echo $row['PortID'];
                                        echo " - ";
                                        if (is_null($row['PortNumber'])) echo "Not Set";
                                        else echo $row['PortNumber'];
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="buttoncontainer mt-3 d-flex gap-2 justify-content-center">
                    <form action="<?= base_url('orders/update/delivery') ?>" method="post">
                        <input type="hidden" name="DeliveryID" value="<?= $row["DeliveryID"] ?>" id="pend">
                        <button id="pendingButton" name="Status" value="Pending" type="submit" class="btn btn-warning" disabled>Set to Pending</button>
                    </form>

                    <form action="<?= base_url('orders/update/delivery') ?>" method="post">
                        <input type="hidden" name="DeliveryID" value="<?= $row['DeliveryID'] ?>" id="dev">
                        <button id="delivButton" name="Status" value="Delivered" type="submit" class="btn btn-success" disabled>Set to Delivered</button>
                    </form>

                    <form action="<?= base_url('orders/update/delivery') ?>" method="post" class="gap-2">
                        <div class="gap-2" style="max-height: 40px;">
                        <input type="hidden" name="DeliveryID" value="<?= $row['DeliveryID'] ?>" id="port">
                        <select title="Assign to Vehicle" id="portSelect" name="PortID" class="form-select" disabled>
                            <option disabled selected value="null">Select Port</option>
                            <option value="0">None</option>
                            <?php
                            $conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");
                            if ($ports = $conn->query("SELECT * FROM delivery_port")) {
                                while ($ports_row = $ports->fetch_assoc()) {
                                    echo "<option value='" . $ports_row["PortID"] . "'>" . $ports_row["PortNumber"] . "</option>";
                                }
                            }
                            ?>
                        </select>
                        <button id="portButton" type="submit" class="mt-2 btn btn-primary px-4" disabled>Assign Vehicle</button>
                        </div>
                    </form>
                    

                </div>
            </div>
        </div>
    </div>

    <?= $this->include("orders/footer") ?>
    <script src="/js/dropdown.js"></script>
    <script src="/js/deliveries.js"></script>
    <script src="/js/filterOrdersStaff.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>