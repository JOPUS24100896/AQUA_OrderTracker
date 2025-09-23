const table = document.getElementById("table_history");
const styleRow = document.getElementById("selectRow");
const pendButton = document.getElementById("pendingButton");
const readButton = document.getElementById("delivButton");
const prtSelect = document.getElementById("portSelect");
const prtButton = document.getElementById("portButton");
let selectId = 0;
let rows;

activateListeners();

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
       // sendStat(forms);
    });
    prtButton.addEventListener("click", function(){
        let forms = new FormData();
        forms.append("DeliveryID", this.dataset.currentDeliv);
        forms.append("PortID", prtSelect.value);
        //sendStat(forms);
    });
}

// function sendStat(formData){
//     fetch("../php/changeDeliveryStatus.php", {
//         method: 'POST', 
//         body: formData
//     }).
//     then(response => response.json()). 
//     then(data => {
//         console.log(data);
//         if(!data.Error){
//             genereateDeliveryList();
//             alert(data.Message);
//         }
//     })
// }

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