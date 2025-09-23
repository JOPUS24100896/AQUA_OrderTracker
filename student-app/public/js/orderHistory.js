const table = document.getElementById("table_history");

fetch("../php/order_history.php").
then(response => response.json()). 
then(data => {
    let row = "";
    let span_count = 0;
    console.log(data);
    data.forEach(rowData => {
        let itemQuantPrice = parseFloat(rowData.ItemQuantity) * rowData.Price;
        row += `
        <tr class="orderRow">
            <td class="orderData">${rowData.ItemName}</td>
            <td class="orderData">${rowData.ItemQuantity}</td>
            <td class="orderData">${itemQuantPrice}</td>
            <td class="orderData OrderDate${rowData.OrderID}">${rowData.OrderDate}</td>
            <td class="orderData OrderPrice${rowData.OrderID}">${rowData.TotalPrice}</td>
        </tr>
    `;
    })
    table.innerHTML = row;
    data.forEach(row => {
        const ColID = document.getElementsByClassName("OrderId" + row.OrderID);
        const ColDate = document.getElementsByClassName("OrderDate" + row.OrderID);
        const ColPrice = document.getElementsByClassName("OrderPrice" + row.OrderID);
        console.log(ColID);
        console.log("OrderId" + row.OrderID)
        if(span_count == 0){
            span_count = ColID.length - 1;
            ColID[0].rowSpan = span_count + 1;
            ColDate[0].rowSpan = span_count + 1;
             ColPrice[0].rowSpan = span_count + 1;
        }else{
            ColID[ColID.length - span_count].remove();
            ColDate[ColDate.length - span_count].remove();
            ColPrice[ColPrice.length - span_count].remove();
            span_count--;
        }
            
    });
});
