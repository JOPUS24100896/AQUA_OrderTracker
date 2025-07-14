const table = document.getElementById("table_history");

fetch("../php/order_history.php").
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
        </tr>
    `;
    })
    table.innerHTML = row;
});
