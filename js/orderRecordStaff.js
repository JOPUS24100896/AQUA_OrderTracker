const table = document.getElementById("table_history");

fetch("C:/Users/USER/Documents/GitHub/AQUA_OrderTracker/php/order_history.php").
then(response => response.json()). 
then(data => {
    let row = "";
    console.log(data);
    data.forEach(rowData => {
        row += `
        <tr>
            <td>${rowData.UserID}</td>
            <td>${rowData.OrderID}</td>
            <td>${rowData.ItemID}</td>
            <td>${rowData.ItemQuantity}</td>
            <td>${rowData.OrderDate}</td>
            <td>${rowData.TotalPrice}</td>
            <td>${rowData.Status}</td>
        </tr>
    `;
    })
    table.innerHTML = row;
    filter();
});

function filter() {
    var row, column, i;
    row = table.getElementsByTagName("tr");
    for (i = 0; i < row.length; i++) {
        column = row[i].getElementsByTagName("td")[6];
        if(column.innerHTML != 'Complete') {
            row[i].style.display = "";
        }else {
            row[i].style.display = "none";
        }       
    }
}