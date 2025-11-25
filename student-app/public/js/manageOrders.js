const table = document.getElementById("table_history");
const form = document.getElementById("form");
const orderIdIn = document.getElementsByClassName("orderID");
const orderStatIn = document.getElementsByClassName("orderStatus");
let style;
let pendButton = document.getElementById("pendingButton");
let readButton = document.getElementById("readyButton");
let selectId = 0;
let rows;
//alert(arr[0]);
generateOrderList();
function generateOrderList(){
    // table.innerHTML = '';
    // fetch("../php/order_record.php").
    // then(response => response.json()). 
    // then(data => {
    //     let row = "";
    //     
    //     data.forEach(rowData => {
    //         row += `
    //     <tr class="orderRow orderNumber${rowData.OrderID}" onclick="current_select(${rowData.OrderID})" data-current-select="0">
    //             <td class="orderData OrderId${rowData.OrderID}">${rowData.OrderID}</td>
    //             <td class="orderData OrderUser${rowData.OrderID}">${rowData.UserID} - ${rowData.Username}</td>
    //             <td class="orderData">${rowData.ItemName}</td>
    //             <td class="orderData">${rowData.ItemQuantity}</td>
    //             <td class="orderData OrderDate${rowData.OrderID}">${rowData.OrderDate}</td>
    //             <td class="orderData OrderPrice${rowData.OrderID}">${rowData.TotalPrice}</td>
    //             <td class="orderData OrderStat${rowData.OrderID}">${rowData.Status}</td>    
    //         </tr>
    //     `;
    // /*somehow get the orderID from the db when clicked and use it to edit*/
    //    })
    let span_count = 0;
        // rows = document.getElementsByClassName("orderRow");
        iteration = 0;
        filter();
        arr.forEach(row => {
            const ColID = document.getElementsByClassName("OrderId" + arr[iteration]);
            const ColDate = document.getElementsByClassName("OrderDate" + arr[iteration]);
            const ColStat = document.getElementsByClassName("OrderStat" + arr[iteration]);
            const ColPrice = document.getElementsByClassName("OrderPrice" + arr[iteration]);
            const ColUser = document.getElementsByClassName("OrderUser" + arr[iteration]);
            if(span_count == 0){
                span_count = ColID.length - 1;
                ColID[0].rowSpan = span_count + 1;
                ColDate[0].rowSpan = span_count + 1;
                ColPrice[0].rowSpan = span_count + 1;
                ColStat[0].rowSpan = span_count + 1;
                ColUser[0].rowSpan = span_count + 1;
            }else{
                ColID[ColID.length - span_count].remove();
                ColDate[ColDate.length - span_count].remove();
                ColPrice[ColPrice.length - span_count].remove();
                ColStat[ColStat.length - span_count].remove();
                ColUser[ColUser.length - span_count].remove();
                span_count--;
            }
            iteration++;
        });
        style = document.getElementById("selectRow");
        activateListeners();
}

function activateListeners(){
    pendButton = document.getElementById("pendingButton");
    readButton = document.getElementById("readyButton");

    orderIdIn[0].addEventListener("SelectionChange", function(event){
        this.value = event.detail.selectedID;
    })

    orderIdIn[1].addEventListener("SelectionChange", function(event){
        this.value = event.detail.selectedID;
    })

    pendButton.addEventListener("SelectionChange", function(event){
        this.dataset.currentSelected = event.detail.selectedID;
        this.disabled = !event.detail.active;
    });
    readButton.addEventListener("SelectionChange", function(event){
        this.dataset.currentSelected = event.detail.selectedID;
        this.disabled = !event.detail.active;
    });

    pendButton.addEventListener("click", function(){
        let forms = new FormData();
        form.append("OrderID", this.dataset.currentSelected);
        form.append("Status", "Pending");
        form.submit();
    });
    readButton.addEventListener("click", function(){
        let forms = new FormData();
        form.append("OrderID", this.dataset.currentSelected);
        form.append("Status", "Ready");
        form.submit();
    });
}

function sendForm(formData){
    fetch("/orders/update/orderStatus", {
                    method: 'POST', 
                    body: formData
        }).
    then(() => { window.location.href = '/orders/staff/manageOrders'})
}

function filter() {
    var row, column, i;
    row = table.getElementsByTagName("tr");
    for (i = 0; i < row.length; i++) {
        column = row[i].getElementsByTagName("td")[6];
        if(column.innerHTML != 'Complete' || column.innerHTML != 'Cancelled') {
            row[i].style.display = "";
        }else {
            row[i].style.display = "none";
        }       
    }
}

function current_select(orderId){
    alert
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
    style.textContent = `.orderNumber${orderId} {background-color: #e0f7fa;}`;
    }
        
    else {
        selectId = 0;
        event = new CustomEvent("SelectionChange", {
            detail: {
                selectedID: selectId,
                active: false
            }
        });
        style.textContent = ``;
    }
    pendButton.dispatchEvent(event);
    readButton.dispatchEvent(event);
    orderIdIn[0].dispatchEvent(event);
    orderIdIn[1].dispatchEvent(event);

}