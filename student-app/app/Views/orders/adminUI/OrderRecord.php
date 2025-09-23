
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Record</title>
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/orderrecord.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
        <?= $this->include("orders/adminUI/adminHeader")?>



    <!-- content -->
    <div id="content">
        <h1 id="page_title">ORDER RECORD</h1>
        <div id="OrderRecordTable">
            <table>
                <thead>
                    <div id="header_background"></div>
                    <tr id="table_header">    
                        <th>ID</th>
                        <th>ItemName</th>
                        <th>ItemQuantity</th>
                        <th>Price</th>
                        <th>OrderDate</th>
                        <th>TotalPrice</th>
                    </tr>
                </thead>
                <tbody id="orderForm">
                   
                </tbody>
            </table>
        </div>
        
    </div>

    

    <div id="footer">
        <div class="flex_center">
            <a href="/ContactInfo.html"><h4>Where to find us</h4></a>
            <a href="/PrivacyPolicy.html"><h4>Privacy Policy</h4></a>
        </div>     
    </div>

    <script src="/js/dropdown.js"></script>
    <script src="/js/orderRecord.js"></script>    
</body>
</html>