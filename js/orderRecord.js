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
    // const card = document.createElement('tr');
    //     card.innerHTML = `
    //         <td>${data.OrderID}</td>
    //         <td>${data.FullName}</td>
    //         <td>${data.OrderDate}</td>
    //         <td>${data.Price}</td>
    //     `;
    //     tableRow.appendChild(card);
}).catch(data => {
    console.log(data);
});







// testing
// const destinationGrid = document.getElementById("orderForm");
// const card = document.createElement('tr');
// card.innerHTML = `
//     <td>1</td>
//         <td>John Doe</td>
//         <td>2023-10-01</td>
//         <td>Completed</td>
// `;
// destinationGrid.appendChild(card);
    
/*fetch("../php/test.json")
.then(response => response.json())
.then(data => {
    order = data;
    const tableRow = document.getElementById("orderForm");
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
});*/
// testing






