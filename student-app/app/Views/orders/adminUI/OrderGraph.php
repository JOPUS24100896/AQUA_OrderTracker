
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
    <style>
        #page_title{
        font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        text-shadow: 0px 0px 2px rgba(0, 0, 0, 0.875);
        font-weight: lighter;
        letter-spacing: .1cm;
        }
    </style>
</head>
<body>
        <?= $this->include("orders/adminUI/adminHeader")?>


    <div id="content">
        <h1 id="page_title">ORDER TREND</h1>
        <div id="salesChartContainer" class="flex_center">
          <div id="myChart" style="  width: 50vw; height: 50vh;"></div>
          <div id="salesLegend">
          </div>          
        </div>
    </div>
    
    
    
    <div id="footer">
        <div class="flex_center">
            <a href="/ContactInfo.html"><h4>Where to find us</h4></a>
            <a href="/PrivacyPolicy.html"><h4>Privacy Policy</h4></a>
        </div>     
    </div>

  
  <script src="/js/dropdown.js"></script>
</body>
</html>