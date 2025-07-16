let chartReady = false;
let dataReady = false;
let chartData = null;

// Load Google Charts
google.charts.load('current', { packages: ['corechart'] });
google.charts.setOnLoadCallback(() => {
  chartReady = true;
  tryRenderChart();
});

// Fetch data
fetch('http://localhost/php/retrieve_orderData.php')
  .then(response => response.json())
  .then(data => {
    const orderCountsByDay = {};
    const uniqueOrders = new Set();
    const weekDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const x = [], y = [];
    let sumOrder = 0;

    data.forEach(order => {
      const orderDate = new Date(order.OrderDate);
      const dayName = orderDate.toLocaleDateString('en-US', { weekday: 'long' });
      const orderKey = `${order.OrderID}`;

      if (!uniqueOrders.has(orderKey)) {
        uniqueOrders.add(orderKey);
        orderCountsByDay[dayName] = (orderCountsByDay[dayName] || 0) + 1;
      }
    });

    weekDays.forEach(day => {
      if (orderCountsByDay[day]) {
        x.push(day);
        y.push(orderCountsByDay[day]);
      }
    });

    const data_array = [['Day', 'Number of Orders']];
    for (let i = 0; i < x.length; i++) {
      data_array.push([x[i], y[i]]);
      sumOrder += y[i];
    }

    const avgOrder = sumOrder / 7;
    document.getElementById("salesLegend").innerHTML = `
      <div class="Legend_Content">
        <h1>Total No. of Orders: ${sumOrder}</h1>
      </div>
      <div class="Legend_Content">
        <h1>Average No. of Orders: ${avgOrder.toFixed(1)}</h1>
      </div>
    `;

    dataReady = true;
    chartData = data_array;
    tryRenderChart();
  });

// Try rendering the chart only when both are ready
function tryRenderChart() {
  if (chartReady && dataReady) {
    try {
      const data = google.visualization.arrayToDataTable(chartData);
      const options = {
        hAxis: { title: 'Day of the Week' },
        vAxis: { title: 'Number of Orders' },
        legend: 'none'
      };
      const chartContainer = document.getElementById('myChart');
      if (!chartContainer) throw new Error("Chart container not found");
      const chart = new google.visualization.LineChart(chartContainer);
      chart.draw(data, options);
      localStorage.removeItem('chartReloaded');
    } catch (error) {
      console.error("Chart rendering failed:", error);
      if (!localStorage.getItem('chartReloaded')) {
        localStorage.setItem('chartReloaded', 'true');
        location.reload();
      } else {
        alert("Chart failed to load after retry.");
        localStorage.removeItem('chartReloaded');
      }
    }
  }
}