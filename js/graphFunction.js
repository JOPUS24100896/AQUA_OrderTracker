google.charts.load('current', { packages: ['corechart'] });
google.charts.setOnLoadCallback(drawChart);

const table = document.getElementById("orderForm");

let orderCountsByDay = {}; // { 'Monday': 3, 'Tuesday': 5, ... }
let uniqueOrders = new Set(); // Track unique OrderIDs to avoid duplicates

fetch('http://localhost/php/retrieve_orderData.php')
.then(response => response.json())
.then(data => {
  data.forEach(order => {
    const orderDate = new Date(order.OrderDate);
    const dayName = orderDate.toLocaleDateString('en-US', { weekday: 'long' });
    const orderKey = `${order.OrderID}`; // Unique order identifier

    if (!uniqueOrders.has(orderKey)) {
      uniqueOrders.add(orderKey);
      orderCountsByDay[dayName] = (orderCountsByDay[dayName] || 0) + 1;
    }
  });

  // Sort days in week order
  const weekDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  const x = [];
  const y = [];

  weekDays.forEach(day => {
    if (orderCountsByDay[day]) {
      x.push(day);
      y.push(orderCountsByDay[day]);
    }
  });

  var sumOrder = 0;
 

  // Prepare chart data
  const data_array = [['Day', 'Number of Orders']];
  for (let i = 0; i < x.length; i++) {
    data_array.push([x[i], y[i]]);
    sumOrder += y[i];
  }
   var avgOrder = sumOrder/7;
  drawChart(data_array);

  const stats = document.getElementById("salesLegend");

  stats.innerHTML = `
    <div class="Legend_Content">
      <h1>Total No. of Orders: ${sumOrder}</h1>
    </div>
    <div class="Legend_Content">
      <h1>Average No. of Orders: ${avgOrder.toFixed(1)}</h1>
    </div>
  `;


});

// Chart rendering function
function drawChart(data_array) {
  const data = google.visualization.arrayToDataTable(data_array);

  const options = {
    hAxis: { title: 'Day of the Week' },
    vAxis: { title: 'Number of Orders' },
    legend: 'none'
  };

  const chart = new google.visualization.LineChart(document.getElementById('myChart'));
  chart.draw(data, options);
}

