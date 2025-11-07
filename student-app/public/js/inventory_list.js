
// function updateStock(itemId) {
//     const input = document.getElementById(`stock-${itemId}`);
//     const addedStock = parseInt(input.value);

//     if (!addedStock || addedStock <= 0) {
//         alert("Please enter a valid stock quantity.");
//         return;
//     }

//     fetch('../php/addStock.php', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json'
//         },
//         body: JSON.stringify({ ItemID: itemId, AddedStock: addedStock })
//     })
//     .then(response => response.json())
//     .then(data => {
//         console.log(data);
//         alert(data.message);
//     })
//     .catch(error => {
//         console.error('Error updating stock:', error);
//     });
//     location.reload();
// }
function updateStock(itemId) {
    const input = document.getElementById(`stock-${itemId}`);
    const addedStock = parseInt(input.value);

    if (!addedStock || addedStock <= 0) {
        alert("Please enter a valid stock quantity.");
        return;
    }

    fetch('/api/add-stock', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ ItemID: itemId, AddedStock: addedStock })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        // Optionally reload or update UI
        location.reload();
    })
    .catch(error => {
        console.error('Error updating stock:', error);
    });
    location.reload();
}