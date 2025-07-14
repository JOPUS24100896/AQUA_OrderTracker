fetch("../php/inventory_list.php").
then(response => response.json()). 
then(data => {
    const tableRow = document.getElementById("orderForm");
    console.log(data);
    data.forEach(item => {
        const card = document.createElement('tr');
        card.innerHTML = `
            <td>${item.ItemID}</td>
            <td>${item.ItemName}</td>
            <td>${item.StockQuantity}</td>
            <td>${item.Price}</td>
        `;
        tableRow.appendChild(card);
    });
})