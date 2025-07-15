const table = document.getElementById("table_history");
let pendButton = document.getElementById("pendingButton");
let readButton = document.getElementById("readyButton");
let selectId = 0;
let rows;
fetch("../php/order_record.php").
then(response => response.json()). 
then(data => {
    let row = "";
    let span_count = 0;
    console.log(data);
    data.forEach(rowData => {
        row += `
       <tr class="orderRow orderNumber${rowData.OrderID}" onclick="current_select(${rowData.OrderID})" data-current-select="0">
            <td class="orderData OrderId${rowData.OrderID}">${rowData.OrderID}</td>
            <td class="orderData">${rowData.UserID}</td>
            <td class="orderData">${rowData.ItemName}</td>
            <td class="orderData">${rowData.ItemQuantity}</td>
            <td class="orderData OrderDate${rowData.OrderID}">${rowData.OrderDate}</td>
            <td class="orderData OrderPrice${rowData.OrderID}">${rowData.TotalPrice}</td>
            <td class="orderData OrderStat${rowData.OrderID}">${rowData.Status}</td>    
        </tr>
    `;
/*somehow get the orderID from the db when clicked and use it to edit*/
    })
    rows = document.getElementsByClassName("orderRow");
    table.innerHTML = row;
    filter();
    data.forEach(row => {
        const ColID = document.getElementsByClassName("OrderId" + row.OrderID);
        const ColDate = document.getElementsByClassName("OrderDate" + row.OrderID);
        const ColStat = document.getElementsByClassName("OrderStat" + row.OrderID);
        const ColPrice = document.getElementsByClassName("OrderPrice" + row.OrderID);
        console.log(ColID);
        console.log("OrderId" + row.OrderID)
        if(span_count == 0){
            span_count = ColID.length - 1;
            ColID[0].rowSpan = span_count + 1;
            ColDate[0].rowSpan = span_count + 1;
            ColPrice[0].rowSpan = span_count + 1;
            ColStat[0].rowSpan = span_count + 1;
        }else{
            ColID[ColID.length - span_count].remove();
            ColDate[ColDate.length - span_count].remove();
            ColPrice[ColPrice.length - span_count].remove();
            ColStat[ColStat.length - span_count].remove();
            span_count--;
        }
            
    });

    activateListeners();

});

function activateListeners(){
    pendButton = document.getElementById("pendingButton");
    readButton = document.getElementById("readyButton");

    pendButton.addEventListener("SelectionChange", function(event){
        this.dataset.currentSelected = event.detail.selectedID;
        this.disabled = !event.detail.active;
    });
    readButton.addEventListener("SelectionChange", function(event){
        this.dataset.currentSelected = event.detail.selectedID;
        this.disabled = !event.detail.active;
    });

    pendButton.addEventListener("click", function(){
        alert("PENDING" + this.dataset.currentSelected);
        let forms = new FormData();
        forms.append("OrderID", this.dataset.currentSelected);
        forms.append("Status", "Pending");
        sendForm(forms);
    });
    readButton.addEventListener("click", function(){
        alert("READY"  + this.dataset.currentSelected);
        let forms = new FormData();
        forms.append("OrderID", this.dataset.currentSelected);
        forms.append("Status", "Ready");
        sendForm(forms);
    });
}

function sendForm(formData){
    fetch("../php/changeOrderStatus.php", {
        method: 'POST', 
        body: formData
    }).
    then(response => response.json()). 
    then(data => {
        console.log(data);
    })
}

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

function current_select(orderId){
    let event;
    if(selectId != orderId){
        selectId = orderId;
        event = new CustomEvent("SelectionChange", {
            detail: {
                selectedID: selectId,
                active: true,
                display:"none"
            }
        });
    }
        
    else {
        selectId = 0;
        event = new CustomEvent("SelectionChange", {
            detail: {
                selectedID: selectId,
                active: false
            }
        });
    }
    pendButton.dispatchEvent(event);
    readButton.dispatchEvent(event);
}