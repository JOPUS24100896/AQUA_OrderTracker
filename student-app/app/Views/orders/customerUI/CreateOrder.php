
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/orderHistory.css">
    <link rel="stylesheet" href="/css/createOrder.css">
    <script>
        let arr = [];
        <?php foreach($data as $dat): ?> arr.push(<?= $dat['ItemID']?>); <?php endforeach;?>
    </script>
</head>

<body>
    <?= $this->include("orders/customerUI/custHeader")?>
    <!--<img src="/uploads/bottle_water.webp" alt="Test">-->
    <!-- Content -->
    <div id="content">
        <h1 id="page_title">CREATE ORDER</h1>
        <form method="post" id="orderForm">
            <!--Order forms procedureally generated-->
            <div class="ProductList">
                <h2 class="title">PRODUCTS</h2>
                <div id="Products" class="productCards">
                    <?php foreach($data as $dat): ?>
                        <div class="productCard">
                            <img src="/uploads/<?= $dat['ImagePath']?>" style='width: 535px; height: 500px;' alt="Product Image" class="ProdImg"><br>
                            <label for="p<?= $dat['ItemID']?>">
                                <input type="checkbox" name="product[]" id="p<?= $dat['ItemID']?>" value="<?= $dat['ItemID']?>" class="ProdName"> 
                                <?= $dat['ItemName']?>
                            </label> <br>

                            <h2>₱<?= $dat['Price']?></h2> <br>
                            <label for="p<?= $dat['ItemID']?>">Number of Orders:</label> <br>
                            <input type="button" value="-" id="p<?= $dat['ItemID']?>min" class="ProdMin"> 
                            <input type="text" name="product_amount[]" id="p<?= $dat['ItemID']?>val" class="ProdVal">
                            <input type="button" value="+" id="p<?= $dat['ItemID']?>add" class="Prodadd"><br>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
            <div class="flex_center">  
                    <div class="deliveryOptions">
                        <label><input type="radio" name="delivery" value="1" class="orderHandling"> Delivery</label>
                        <label><input type="radio" name="delivery" value="0" class="orderHandling"> On-Site</label>
                    </div>
                    <div id="deliveryDetails"></div>
            </div>  
            <input type="submit" value="Submit Order" class="orderHandling">
        </form>

    </div>
    <?= $this->include("orders/footer")?>

    <script src="/js/dropdown.js"></script>
    <!--<script src="/js/productlist.js"></script>-->
    <script src="/js/createorder.js"></script>
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