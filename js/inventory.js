const table = document.getElementById("orderForm");

fetch('http://localhost/php/inventory_list.php')
.then(response => response.json())
.then(data => {
    console.log(data);
    data.forEach(inventory => {
        const card = document.createElement('tr');
        card.innerHTML = `
            <td>${inventory.ItemID}1</td>
            <td>${inventory.ItemName}</td>
            <td>${inventory.StockQuantity}</td>
            <td>${inventory.Price}</td>
        `;
    });
    table.appendChild(card);
});