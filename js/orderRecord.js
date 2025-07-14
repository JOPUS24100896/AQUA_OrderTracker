const table = document.getElementById("orderForm");

var prev_orderID = null;
var prev_orderDate = null;


// fetch("../php/retrieve_orderData.php")
fetch('http://localhost/php/retrieve_orderData.php')
.then(response => response.json())
// .then(data => {
//     if(prev_orderID == order.OrderID && prev_orderDate == order.OrderDate){

//     } else{
//       console.log(data);
//     data.forEach(order => {
//         const card = document.createElement('tr');
//         card.innerHTML = `
//             <td>${order.OrderID}</td>
//             <td>${order.FullName}</td>
//             <td>${order.OrderDate}</td>
//             <td>${order.Price}</td>
//         `;
//     });
//     }
//     table.appendChild(card);
// })
.then(data => {
    let row = "";
    let span_count = 0;
    console.log(data);
    data.forEach(rowData => {
        let itemQuantPrice = parseFloat(rowData.ItemQuantity) * rowData.Price;
        row += `
        <tr class="orderRow">
            <td class="orderData OrderId${rowData.OrderID}">${rowData.OrderID}</td>
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





