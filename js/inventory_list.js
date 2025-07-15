fetch("../php/inventory_list.php").
then(response => response.json()). 
then(data => {
    const tableRow = document.getElementById("orderForm");
    console.log(data);
    data.forEach(item => {
        const card = document.createElement('tr');
        card.innerHTML = `
            <td>${item.ItemID}</td>
            <div class="productCard"><img src="../php/viewImage.php?id=${item.ItemID}
            <td>${item.ItemName}</td>
            <td>${item.StockQuantity}</td>
            <td>${item.Price}</td>
            <td class="inputBox">
                <input type="number" min="1" placeholder="Add stock" id="stock-${item.ItemID}">
                <button onclick="updateStock(${item.ItemID})">ADD</button>
            </td>

        `;
        tableRow.appendChild(card);
    });
})

function updateStock(itemId) {
    const input = document.getElementById(`stock-${itemId}`);
    const addedStock = parseInt(input.value);

    if (!addedStock || addedStock <= 0) {
        alert("Please enter a valid stock quantity.");
        return;
    }

    fetch('../php/addStock.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ ItemID: itemId, AddedStock: addedStock })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        alert(data.message);
    })
    .catch(error => {
        console.error('Error updating stock:', error);
    });
    location.reload();
}