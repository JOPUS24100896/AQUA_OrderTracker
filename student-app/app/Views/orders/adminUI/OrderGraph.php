<?php ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Record</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/trend.css">
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="/js/graphFunction.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/index.css">
    <style>
        #page_title {
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            text-shadow: 0px 0px 2px rgba(0, 0, 0, 0.875);
            font-weight: lighter;
            letter-spacing: .1cm;
        }
    </style>
</head>

<body>
    <?= $this->include("orders/adminUI/adminHeader") ?>

    <div class="container" style="padding-top: 100px; padding-bottom: 80px">
        <div class="card shadow-lg rounded-4">
            <div class="card-body" style="min-height: 600px;">

                <h1 class="fw-bold text-center mb-4">ORDER TREND</h1>

                <div class="row justify-content-center align-items-start">

                    <!-- Chart -->
                    <div class="col-lg-8 col-md-10 mb-4">
                        <div class="p-3 border rounded bg-light shadow-sm">
                            <div id="myChart" style="height: 55vh;"></div>
                        </div>
                    </div>

                    <!-- Legend -->
                    <div class="col-lg-3 col-md-6">
                        <div id="salesLegend"
                            class="p-3 border rounded bg-white shadow-sm"
                            style="min-height: 200px;">
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>



    <?= $this->include("orders/footer") ?>

    <script src="/js/dropdown.js"></script>
</body>

</html>