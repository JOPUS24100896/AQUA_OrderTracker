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
            <td class="orderData OrderId${rowData.OrderID}">${rowData.OrderID}</td>
            <td class="orderData">${rowData.ItemName}</td>
            <td class="orderData">${itemQuantPrice}</td>
            <td class="orderData OrderDate${rowData.OrderID}">${rowData.OrderDate}</td>
            <td class="orderData OrderPrice${rowData.OrderID}">${rowData.TotalPrice}</td>
            <td class="orderData OrderStat${rowData.OrderID}">${rowData.Status}</td>
        </tr>
    `;
    });
    table.innerHTML = row;
    filter();
    data.forEach(rowData => {
        const ColID = document.getElementsByClassName("OrderId" + rowData.OrderID);
        const ColDate = document.getElementsByClassName("OrderDate" + rowData.OrderID);
        const ColPrice = document.getElementsByClassName("OrderPrice" + rowData.OrderID);
        const ColStat = document.getElementsByClassName("OrderStat" + rowData.OrderID);
        console.log(ColID);
        console.log("OrderId" + rowData.OrderID)
        if(span_count == 0){
            span_count = ColID.length - 1;
            ColID[0].rowSpan = span_count + 1;
            ColDate[0].rowSpan = span_count + 1;
            ColPrice[0].rowSpan = span_count + 1;
            ColStat[0].rowSpan = span_count + 1;
        }else{
            ColID[ColID.length - span_count].remove();
            ColDate[ColDate.length - span_count].remove();
            ColPrice[ColPrice.length - span_count].remove();
            ColStat[ColStat.length - span_count].remove();
            span_count--;
        }
            
    });

    //filter();
});

function filter() {
    var row, column, i;
    row = table.getElementsByTagName("tr");
    for (i = 0; i < row.length; i++) {
        column = row[i].getElementsByTagName("td")[5];
        if(column.innerHTML != 'Complete') {
            row[i].style.display = "";
        }else {
            row[i].style.display = "none";
        }       
    }
}
