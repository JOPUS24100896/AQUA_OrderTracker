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
            <div class="card-body p-5">

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

    <!-- <script>
    let chartReady = false;
    let dataReady = false;
    let chartData = null;

    // Load Google Charts after everything else
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(() => {
    chartReady = true;
    tryRenderChart();
    });

    fetch('/orders/admin/orderGraph')
    .then(response => response.json())
    .then(data => {
        const orderCountsByDay = {};
        const uniqueOrders = new Set();
        const weekDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const x = [], y = [];
        let sumOrder = 0;

        // Track item frequency and names
        const itemFrequency = {}; 
        const itemNameMap = {};  

        data.forEach(order => {
        const orderDate = new Date(order.OrderDate);
        const dayName = orderDate.toLocaleDateString('en-US', { weekday: 'long' });
        const orderKey = `${order.OrderID}`;
        const itemID = order.ItemID;
        const itemName = order.ItemName;

        // Count unique orders per day
        if (!uniqueOrders.has(orderKey)) {
            uniqueOrders.add(orderKey);
            orderCountsByDay[dayName] = (orderCountsByDay[dayName] || 0) + 1;
        }

        // Map ItemID to ItemName
        itemNameMap[itemID] = itemName;

        // Count item frequency by name
        itemFrequency[itemName] = (itemFrequency[itemName] || 0) + 1;
        });

        let mostSoughtItemName = null;
        let maxCount = 0;

        for (const [name, count] of Object.entries(itemFrequency)) {
        if (count > maxCount) {
            maxCount = count;
            mostSoughtItemName = name;
        }
        }

        weekDays.forEach(day => {
        if (orderCountsByDay[day]) {
            x.push(day);
            y.push(orderCountsByDay[day]);
        }
        });

        const data_array = [['Day', 'Number of Orders']];
        for (let i = 0; i < x.length; i++) {
        data_array.push([x[i], y[i]]);
        sumOrder += y[i];
        }

        const avgOrder = sumOrder / 7;
        document.getElementById("salesLegend").innerHTML = `
        <div class="Legend_Content">
            <h1>Total No. of Orders: ${sumOrder}</h1>
        </div>
        <div class="Legend_Content">
            <h1>Average No. of Orders: ${avgOrder.toFixed(1)}</h1>
        </div>
        <div class="Legend_Content">
            <h1>Most Sought Item:<br>${mostSoughtItemName}</h1>
            <p>Ordered ${maxCount} times</p>
        </div>


        `;

        dataReady = true;
        chartData = data_array;
        tryRenderChart();
    });

    // Try rendering the chart only when both are ready
    function tryRenderChart() {
    if (chartReady && dataReady) {
        try {
        const data = google.visualization.arrayToDataTable(chartData);
        const options = {
            hAxis: { title: 'Day of the Week' },
            vAxis: { title: 'Number of Orders' },
            legend: 'none'
        };
        const chartContainer = document.getElementById('myChart');
        if (!chartContainer) throw new Error("Chart container not found");
        const chart = new google.visualization.LineChart(chartContainer);
        chart.draw(data, options);
        localStorage.removeItem('chartReloaded');
        } catch (error) {
        console.error("Chart rendering failed:", error);
        if (!localStorage.getItem('chartReloaded')) {
            localStorage.setItem('chartReloaded', 'true');
            location.reload();
        } else {
            alert("Chart failed to load after retry.");
            localStorage.removeItem('chartReloaded');
        }
        }
    }
    }


  </script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>