//         // LINE CHART
// // Sample data with two datasets, each for a different Y-axis
// const data = {
// labels: ['1', '2', '3', '4', '5', '6', '7'],
// datasets: [
//     {
//     label: 'Sales',
//     data: [100, 200, 150, 300, 250],
//     borderColor: 'blue',
//     yAxisID: 'y'
//     },
//     {
//     label: 'Revenue',
//     data: [1000, 1500, 1200, 1800, 1600],
//     borderColor: 'green',
//     yAxisID: 'y1'
//     }
// ]
// };

// // Your provided config object
// const config = {
//     type: 'line',
//     data: data,
//     options: {
//         responsive: true,
//         interaction: {
//             mode: 'index',
//             intersect: false,
//         },
//         stacked: false,
//         plugins: {
//             title: {
//                 display: false,
//                 text: 'Business Report'
//             }
//         },
//         scales: {
//             y: {
//                 type: 'linear',
//                 display: true,
//                 position: 'left',
//             },
//             y1: {
//                 type: 'linear',
//                 display: true,
//                 position: 'right',
//                 grid: {
//                 drawOnChartArea: false,
//                 },
//             },
//         }
//     },
// };

// // Render the chart
// const ctx = document.getElementById('myChart').getContext('2d');
// const myChart = new Chart(ctx, config);

const xValues = [1, 2, 3, 4, 5, 6, 7];

new Chart("myChart", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{
      data: [860,1140,1060,1060,1070,1110,1330,2210,7830,2478],
      borderColor: "red",
      fill: false
    },{
      data: [1600,1700,1700,1900,2000,2700,4000,5000,6000,7000],
      borderColor: "green",
      fill: false
    },{
      data: [300,700,2000,5000,6000,4000,2000,1000,200,100],
      borderColor: "blue",
      fill: false
    }]
  },
  options: {
    legend: {display: false},
    // responsive: true,
    // interaction: {
    //     mode: 'index',
    //     intersect: false,
    // },
  }
});