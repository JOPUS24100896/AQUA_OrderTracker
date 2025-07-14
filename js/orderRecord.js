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
}).catch(data => {
    console.log(data);
});







// testing
// fetch("../php/test.json")
// .then(response => response.json())
// .then(data => {
//     orderData = data;
//     const tableRow = document.getElementById("orderForm");
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
// });
// testing






