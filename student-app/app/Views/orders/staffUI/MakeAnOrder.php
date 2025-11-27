<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make an Order</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/index.css">
    <script>
        let arr = [];
        <?php foreach ($data as $dat): ?> arr.push(<?= $dat['ItemID'] ?>);
        <?php endforeach; ?>
    </script>
</head>

<body>
    <?php include "staffHeader.php" ?>
    <?php if (isset($message)) echo $message; ?>
    <!-- content -->
    <section>
        <div class="container" style="padding-top: 100px; padding-bottom: 20px;">
            <div class="card shadow-lg p-4 mb-5 mt-1" style="border-radius: 30px;">
                <form method="post" id="orderForm" action="<?= base_url('orders/create/makeOrder') ?>">

                    <h1 class="fw-bold mb-3 mt-3 text-center">PRODUCTS</h1>

                    <div class="row g-4">
                        <?php foreach ($data as $dat): ?>
                            <div class="col-md-4 col-sm-6">
                                <div class="card shadow-sm p-3 text-center"
                                    style="border-radius: 30px; min-height: 300px;">

                                    <img src="/uploads/<?= $dat['ImagePath'] ?>"
                                        class="card-img-top mb-3 rounded"
                                        style="height: 250px; object-fit: cover; border-radius: 30px" alt="Product Image">

                                    <div class="card-body">

                                        <label class="form-check-label w-100 mb-2">
                                            <input type="checkbox"
                                                name="product[]"
                                                id="p<?= $dat['ItemID'] ?>"
                                                value="<?= $dat['ItemID'] ?>"
                                                class="form-check-input me-2">
                                            <?= $dat['ItemName'] ?>
                                        </label>

                                        <h5 class="fw-bold">₱<?= $dat['Price'] ?></h5>

                                        <label class="mt-2">Number of Orders:</label>

                                        <div class="d-flex justify-content-center align-items-center gap-2 mt-2">
                                            <button type="button" id="p<?= $dat['ItemID'] ?>min" class="btn btn-outline-secondary btn-sm">−</button>

                                            <input type="text"
                                                name="product_amount[]"
                                                id="p<?= $dat['ItemID'] ?>val"
                                                class="form-control text-center"
                                                style="width: 60px;">

                                            <button type="button" id="p<?= $dat['ItemID'] ?>add" class="btn btn-outline-secondary btn-sm">+</button>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary px-4 py-2">Submit Order</button>
                    </div>

                </form>
            </div>
        </div>
    </section>




    <?= $this->include("orders/footer") ?>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>