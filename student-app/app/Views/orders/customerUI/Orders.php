
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/orders.css">
    <link rel="stylesheet" href="/css/orderHistory.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css">
    <style id="selectRow"></style>
    <script>
        const arr = [];
        <?php foreach ($data as $dat):?> arr.push(<?= $dat['OrderID']?>); <?php endforeach;?> 
     </script>
</head>

<body>
        <?= $this->include("orders/customerUI/custHeader")?>

    <!-- Content -->
    <div id="content">
        <h1 id="page_title">PENDING ORDERS</h1>
        <div class="OrderList">
            <table>
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Item Name</th>
                        <th>Price</th>
                        <th>Order Date</th>
                        <th>TotalPrice</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="table_history">
                    <?php foreach($data as $dat):?>
                        <tr class="orderRow OrderRow<?= $dat['OrderID']?>">
                            <td class="orderData OrderId<?= $dat['OrderID']?>"><?= $dat['OrderID']?></td>
                            <td class="orderData"><?= $dat['ItemName']?></td>
                            <td class="orderData"><?= $dat['Price']?></td>
                            <td class="orderData OrderDate<?= $dat['OrderID']?>"><?= $dat['OrderDate']?></td>
                            <td class="orderData OrderPrice<?= $dat['OrderID']?>"><?= $dat['TotalPrice']?></td>
                            <td class="orderData OrderStat<?= $dat['OrderID']?>"><?= $dat['Status']?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <div class="buttoncontainer">
            
                <button id="cancelOrderButton">Cancel Order</button>
            
            <label for ="cancelButton" id="confirmPrompt" hidden> 
                <span style="color:white;">
                    <h3>Are you sure you want to cancel your order?<h3>
                </span>
                <form method="post" action="<?= base_url('orders/cust/cancelOrder')?>" style="display: inline-block;">
                    <button id="cancelYesButton" >Yes</button>
                </form>
                <button id="cancelNoButton" >No</button>
            </label>
        </div>
    </div>



            <?= $this->include("orders/footer")?>


    <script src="/js/dropdown.js"></script>
    <script src="/js/pendingOrder.js"></script>
    <script>
        document.querySelectorAll('.ProductCard').forEach(card => {
            const minus = card.querySelector('button:first-child');
            const plus = card.querySelector('button:last-child');
            const count = card.querySelector('span');

            minus.addEventListener('click', () => {
                let val = parseInt(count.textContent);
                if (val > 0) count.textContent = val - 1;
            });

            plus.addEventListener('click', () => {
                let val = parseInt(count.textContent);
                count.textContent = val + 1;
            });
        });
    </script>

</body>

</html>