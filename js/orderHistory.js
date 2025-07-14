const table = document.getElementById("table_history");

fetch("../php/order_history.php").
then(response => response.json()). 
then(data => {
    let row = "";
    let span_count = 0;
    console.log(data);
    data.forEach(rowData => {
        row += `
        <tr class="orderRow">
            <td class="orderData OrderId${rowData.OrderID}">${rowData.OrderID}</td>
            <td class="orderData">${rowData.ItemID}</td>
            <td class="orderData">${rowData.ItemQuantity}</td>
            <td class="orderData">${rowData.OrderDate}</td>
            <td class="orderData">${rowData.TotalPrice}</td>
        </tr>
    `;
    })
    table.innerHTML = row;
    data.forEach(row => {
        const Col = document.getElementsByClassName("OrderId" + row.OrderID);
        console.log(Col);
        console.log("OrderId" + row.OrderID)
        if(span_count == 0){
            span_count = Col.length - 1;
            Col[0].rowSpan = span_count + 1;
        }else{
            Col[Col.length - span_count].remove();
            span_count--;
        }
            
    });
});
