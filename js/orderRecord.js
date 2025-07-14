fetch("../php/retrieve_orderData.php")
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






