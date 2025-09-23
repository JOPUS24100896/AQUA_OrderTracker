const table = document.getElementById("table_history");

filter();

function filter() {
    var row, column, i;
    row = table.getElementsByTagName("tr");
    for (i = 0; i < row.length; i++) {
        column = row[i].getElementsByTagName("td")[6];
        if(column.innerHTML != 'Complete') {
            row[i].style.display = "";
        }else {
            row[i].style.display = "none";
        }       
    }
}