const table = document.getElementById("table_history");
const styleRow = document.getElementById("selectRow");
const pendButton = document.getElementById("pendingButton");
const readButton = document.getElementById("delivButton");
const prtSelect = document.getElementById("portSelect");
const prtButton = document.getElementById("portButton");
const pend = document.getElementById("pend");
const dev = document.getElementById("dev");
const port = document.getElementById("port");

let selectId = 0;
let rows;

activateListeners();

function activateListeners(){

    pendButton.addEventListener("SelectionChange", function(event){
        this.dataset.currentSelected = event.detail.selectedID;
        this.dataset.currentDeliv = event.detail.delivery;
        port.dataset.currentDeliv = event.detail.delivery;
        pend.value = event.detail.delivery;
        this.disabled = !event.detail.active;
    });
    readButton.addEventListener("SelectionChange", function(event){
        this.dataset.currentSelected = event.detail.selectedID;
        port.dataset.currentDeliv = event.detail.delivery;
        this.dataset.currentDeliv = event.detail.delivery;
        dev.value = event.detail.delivery;
        this.disabled = !event.detail.active;
    });
    prtSelect.addEventListener("SelectionChange", function(event){
        this.dataset.currentSelected = event.detail.selectedID;
        port.dataset.currentDeliv = event.detail.delivery;
        port.value = event.detail.delivery;
        this.disabled = !event.detail.active;
    });
    prtButton.addEventListener("SelectionChange", function(event){
        this.dataset.currentSelected = event.detail.selectedID;
        port.dataset.currentDeliv = event.detail.delivery;
        port.value = event.detail.delivery;
        this.disabled = !event.detail.active;
    });

    // pendButton.addEventListener("click", function(){
    //     let forms = new FormData();
    //     forms.append("DeliveryID", this.dataset.currentDeliv);
    //     forms.append("Status", "Pending");
    //     //sendStat(forms);
    // });
    // readButton.addEventListener("click", function(){
    //     let forms = new FormData();
    //     forms.append("DeliveryID", this.dataset.currentDeliv);
    //     forms.append("Status", "Delivered");
    //     //sendStat(forms);
    // });
    // prtButton.addEventListener("click", function(){
    //     let forms = new FormData();
    //     forms.append("DeliveryID", this.dataset.currentDeliv);
    //     forms.append("PortID", prtSelect.value);
    //     //sendStat(forms);
    // });
}

function sendStat(formData) {
    fetch("/orders/update/delivery", {
        method: 'POST',
        body: formData
    })
    .then(res => res.json()) 
    .then(data => {
        alert(data.message); 
        if (data.success) {
            window.location.href = "/orders/staff/deliveries";
        }
    })
    .catch(err => {
        alert("Something went wrong: " + err);
    });
}

function current_select(orderId, deliveryId){
    let event;

    // Remove highlights from all buttons
    document.querySelectorAll('.selectBtn').forEach(btn => btn.classList.remove('selectBtn-selected'));

    if(selectId != orderId){
        selectId = orderId;

        // Highlight the row
        styleRow.textContent = `.orderRow { background-color: inherit; } 
                                .orderNumber${deliveryId} { background-color: #00d4f0ff; }`;

        // Highlight the select button in this row
        const row = document.querySelector('.orderNumber' + deliveryId);
        if(row){
            const btn = row.querySelector('.selectBtn');
            if(btn) btn.classList.add('selectBtn-selected');
        }

        event = new CustomEvent("SelectionChange", {
            detail: {
                selectedID: orderId,
                delivery: deliveryId,
                active: true,
                display:"none"
            }
        });

    } else {
        selectId = 0;

        // Remove row highlight
        styleRow.textContent = `.orderRow { background-color: inherit; }`;

        event = new CustomEvent("SelectionChange", {
            detail: {
                selectedID: selectId,
                delivery: deliveryId,
                active: false
            }
        });
    }

    // Dispatch your existing events
    pendButton.dispatchEvent(event);
    readButton.dispatchEvent(event);
    prtSelect.dispatchEvent(event);
    prtButton.dispatchEvent(event);
}

