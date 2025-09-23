
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make an Order</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/createOrder.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css">
</head>

<body>
<?php include "staffHeader.php"?>

    <!-- Content -->
    <div id="content">
        <h1 id="page_title">MAKE AN ORDER</h1>
        <form method="post" id="orderForm">
            <!--Order forms procedureally generated-->
            <div class="ProductList">
                <div id="Products" class="productCards"></div>
            </div>
        </form>

    </div>



    </div>


    <?= $this->include("orders/footer")?>


    <script src="/js/productlist.js"></script>
    <script src="/js/createorder.js"></script>
    <script src="/js/dropdown.js"></script>
    <script>
        // Handle the plus and minus buttons for product quantity
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
