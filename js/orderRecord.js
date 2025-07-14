// fetch("../php/retrieve_orderData.php")
// .then(response => response.json())
// .then(data => {
//     const tableRow = document.getElementById("orderForm");
//     console.log(data);
//     data.forEach(order => {
//         const card = document.createElement('tr');
//         card.innerHTML = `
//             <td>${order.OrderID}</td>
//             <td>${order.FullName}</td>
//             <td>${order.OrderDate}</td>
//             <td>${order.Price}</td>
//         `;
//         tableRow.appendChild(card);
//     });
// })

fetch("../php/test.json")
.then(response => response.json())
.then(data => {
    const tableRow = document.getElementById("orderForm");
    console.log(data);
    data.forEach(order => {
        const card = document.createElement('tr');
        card.innerHTML = `
            <td>${order.OrderID}</td>
            <td>${order.FullName}</td>
            <td>${order.OrderDate}</td>
            <td>${order.Price}</td>
        `;
        tableRow.appendChild(card);
    });
})

function myFunction() {
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





