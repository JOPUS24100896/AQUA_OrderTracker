const table = document.getElementById("table_history");
let style = document.getElementById("selectRow");
let canButton;
let selectId = 0;
let confirmPrompt;
let confirmYesButton = document.getElementById("cancelYesButton");
let confirmNoButton = document.getElementById("cancelNoButton");
let rows;
generatePendingOrder();
function generatePendingOrder(){
    fetch("../php/order_pending.php").
    then(response => response.json()). 
    then(data => {
        let row = "";
        let span_count = 0;
        console.log(data);
        data.forEach(rowData => {
            let itemQuantPrice = parseFloat(rowData.ItemQuantity) * rowData.Price;
            row += `
            <tr class="orderRow orderNumber${rowData.OrderID}" onclick="current_select(${rowData.OrderID})">
                <td class="orderData OrderId${rowData.OrderID}">${rowData.OrderID}</td>
                <td class="orderData">${rowData.ItemName}</td>
                <td class="orderData">${itemQuantPrice}</td>
                <td class="orderData OrderDate${rowData.OrderID}">${rowData.OrderDate}</td>
                <td class="orderData OrderPrice${rowData.OrderID}">${rowData.TotalPrice}</td>
                <td class="orderData OrderStat${rowData.OrderID}">${rowData.Status}</td>
            </tr>
        `;
        });
        table.innerHTML = row;
        filter();
        data.forEach(rowData => {
            const ColID = document.getElementsByClassName("OrderId" + rowData.OrderID);
            const ColDate = document.getElementsByClassName("OrderDate" + rowData.OrderID);
            const ColPrice = document.getElementsByClassName("OrderPrice" + rowData.OrderID);
            const ColStat = document.getElementsByClassName("OrderStat" + rowData.OrderID);
            console.log(ColID);
            console.log("OrderId" + rowData.OrderID)
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
        //filter();
    });
}

function filter() {
    var row, column, i;
    row = table.getElementsByTagName("tr");
    for (i = 0; i < row.length; i++) {
        column = row[i].getElementsByTagName("td")[5];
        if(column.innerHTML != 'Complete') {
            row[i].style.display = "";
        }else {
            row[i].style.display = "none";
        }       
    }
}


function activateListeners(){
    canButton = document.getElementById("cancelOrderButton");
    confirmPrompt = document.getElementById("confirmPrompt");

    canButton.addEventListener("SelectionChange", function(event){
        this.dataset.currentSelected = event.detail.selectedID;
        this.disabled = !event.detail.active;
        if(event.detail.active) this.removeAttribute("hidden");
        else this.setAttribute("hidden", "");
    });
    canButton.addEventListener("click", function(){
        confirmPrompt.removeAttribute("hidden");
        this.setAttribute("hidden", "")
    });
    confirmYesButton.addEventListener("click", function(){

        let formData = new FormData();
        formData.append("order_id", selectId);
        sendForm(formData);

        selectId = 0;
        style.textContent = ``;
        confirmPrompt.setAttribute("hidden", "");
    });
    confirmNoButton.addEventListener("click", function(){
        selectId = 0;
        style.textContent = ``;
        confirmPrompt.setAttribute("hidden", "");
    });
}

function sendForm(formData){
    fetch("../php/cancelOrder.php", {
        method: 'POST',
        body: formData
    }). 
    then(res=>res.json()). 
    then(data => {
        generatePendingOrder();
    })
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
        confirmPrompt.setAttribute("hidden", "");
        event = new CustomEvent("SelectionChange", {
            detail: {
                selectedID: selectId,
                active: false
            }
        });
        style.textContent = ``;
    }
    canButton.dispatchEvent(event);
    
}
