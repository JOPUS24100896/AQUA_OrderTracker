const table = document.getElementById("orderForm");

var prev_orderID = null;
var prev_orderDate = null;


fetch('http://localhost/php/retrieve_orderData.php')
.then(response => response.json())
.then(data => {
    let row = "";
    let span_count = 0;
    console.log(data);
    data.forEach(rowData => {
        let itemQuantPrice = parseFloat(rowData.ItemQuantity) * rowData.Price;
        row += `
        <tr class="orderRow">
            <td id="orderId" class="OrderId${rowData.OrderID}">${rowData.OrderID}</td>
            <td class="orderName">${rowData.ItemName}</td>
            <td class="orderQuantity">${rowData.ItemQuantity}</td>
            <td class="orderPrice">${itemQuantPrice}</td>
            <td id="orderDate" class="OrderDate${rowData.OrderID}">${rowData.OrderDate}</td>
            <td id="orderPrice" class="OrderPrice${rowData.OrderID}">${rowData.TotalPrice}</td>
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
function searchFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("OrderRecordTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}





