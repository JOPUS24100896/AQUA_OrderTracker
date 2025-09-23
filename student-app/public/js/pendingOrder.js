const table = document.getElementById("table_history");
let style = document.getElementById("selectRow");
let canButton;
let selectId = 0;
let confirmPrompt;
let confirmYesButton = document.getElementById("cancelYesButton");
let confirmNoButton = document.getElementById("cancelNoButton");
let rows;
let span_count = 0;
iteration = 0;

arr.forEach(rowData => {
    const ColID = document.getElementsByClassName("OrderId" + rowData);
    const ColDate = document.getElementsByClassName("OrderDate" + rowData);
    const ColPrice = document.getElementsByClassName("OrderPrice" + rowData);
    const ColStat = document.getElementsByClassName("OrderStat" + rowData);
    iteration++;
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

// function sendForm(formData){
//     fetch("../php/cancelOrder.php", {
//         method: 'POST',
//         body: formData
//     }). 
//     then(res=>res.json()). 
//     then(data => {
//         generatePendingOrder();
//     })
// }

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
