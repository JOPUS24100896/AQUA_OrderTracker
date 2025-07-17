const table = document.getElementById("table_history");
const styleRow = document.getElementById("selectRow");
const pendButton = document.getElementById("pendingButton");
const readButton = document.getElementById("delivButton");
const prtSelect = document.getElementById("portSelect");
const prtButton = document.getElementById("portButton");
let selectId = 0;
let rows;

genereateDeliveryList();
activateListeners();
function genereateDeliveryList(){
    table.innerHTML = '';
    fetch("../php/delivery_record.php").
    then(response => response.json()). 
    then(data => {
        let row = "";
        let span_count = 0;
        console.log(data);
        data.forEach(rowData => {
            row += `
        <tr class="orderRow orderNumber${rowData.OrderID}" onclick="current_select(${rowData.OrderID},${rowData.DeliveryID})" data-current-select="0">
                <td class="orderData">${rowData.OrderID}</td>
                <td class="orderData">${rowData.UserID} - ${rowData.Username}</td>
                <td class="orderData">${rowData.OrderDate}</td>
                <td class="orderData">${rowData.TotalPrice}</td>
                <td class="orderData">${rowData.DeliveryStatus}</td>   
                <td class="orderData">${(rowData.PortID == null)?'Not set':rowData.PortID} - ${(rowData.PortNumber == null)?'Not set':rowData.PortNumber}</td>   
            </tr>
        `;
    /*somehow get the orderID from the db when clicked and use it to edit*/
        })
        rows = document.getElementsByClassName("orderRow");
        table.innerHTML = row; 
    });
}

function activateListeners(){

    pendButton.addEventListener("SelectionChange", function(event){
        this.dataset.currentSelected = event.detail.selectedID;
        this.dataset.currentDeliv = event.detail.delivery;
        this.disabled = !event.detail.active;
    });
    readButton.addEventListener("SelectionChange", function(event){
        this.dataset.currentSelected = event.detail.selectedID;
        this.dataset.currentDeliv = event.detail.delivery;
        this.disabled = !event.detail.active;
    });
    prtSelect.addEventListener("SelectionChange", function(event){
        this.dataset.currentSelected = event.detail.selectedID;
        this.dataset.currentDeliv = event.detail.delivery;
        this.disabled = !event.detail.active;
    });
    prtButton.addEventListener("SelectionChange", function(event){
        this.dataset.currentSelected = event.detail.selectedID;
        this.dataset.currentDeliv = event.detail.delivery;
        this.disabled = !event.detail.active;
    });

    pendButton.addEventListener("click", function(){
        let forms = new FormData();
        forms.append("DeliveryID", this.dataset.currentDeliv);
        forms.append("Status", "Pending");
        sendStat(forms);
    });
    readButton.addEventListener("click", function(){
        let forms = new FormData();
        forms.append("DeliveryID", this.dataset.currentDeliv);
        forms.append("Status", "Delivered");
        sendStat(forms);
    });
    prtButton.addEventListener("click", function(){
        let forms = new FormData();
        forms.append("DeliveryID", this.dataset.currentDeliv);
        forms.append("PortID", prtSelect.value);
        sendStat(forms);
    });
}

function sendStat(formData){
    fetch("../php/changeDeliveryStatus.php", {
        method: 'POST', 
        body: formData
    }).
    then(response => response.json()). 
    then(data => {
        console.log(data);
        if(!data.Error){
            genereateDeliveryList();
            alert(data.Message);
        }
    })
}

function current_select(orderId, deliveryId){
    let event;
    if(selectId != orderId){
        selectId = orderId;
        event = new CustomEvent("SelectionChange", {
            detail: {
                selectedID: orderId,
                delivery: deliveryId,
                active: true,
                display:"none"
            }
        });
    styleRow.textContent = `.orderNumber${orderId} {background-color: #e0f7fa;}`;
    }
        
    else {
        selectId = 0;
        event = new CustomEvent("SelectionChange", {
            detail: {
                selectedID: selectId,
                delivery: deliveryId,
                active: false
            }
        });
        styleRow.textContent = ``;
    }
    pendButton.dispatchEvent(event);
    readButton.dispatchEvent(event);
    prtSelect.dispatchEvent(event);
    prtButton.dispatchEvent(event);
}