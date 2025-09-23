const form = document.getElementById("orderForm");

    arr.forEach(enableEventListener);

    // form.addEventListener("submit", function(event){
    //     event.preventDefault();
    //     var orderData = new FormData(this);
    //     fetch("../php/create_order.php", {
    //         method: 'POST',
    //         body: orderData
    //     }).
    //     then(response=>response.json()).
    //     then(data => {
    //         let OrderDone_event = new Event("OrderReceived");
    //         document.dispatchEvent(OrderDone_event);
    //         console.log(data);
    //         if(!data.Error) alert("Order submitted");
    //         else alert(data.Error_Location);
    //     });
    //     this.reset();

    // });


function enableEventListener(item){
    let p = document.getElementById(`p${item}`);
    let padd = document.getElementById(`p${item}add`);
    let pmin = document.getElementById(`p${item}min`);
    let pval = document.getElementById(`p${item}val`);

    padd.disabled=true;
    pmin.disabled=true;
    pval.disabled=true;;

    p.addEventListener("change", function(){
        if(p.checked){
            padd.disabled=false;
            pmin.disabled=false;
            pval.disabled=false;
            pval.value = 1;
        }else{
            padd.disabled=true;
            pmin.disabled=true;
            pval.disabled=true;
            pval.value = null;
        }
    })

    pval.addEventListener("keydown", function(event){
        if(isNaN(parseInt(event.key)) && event.key != "Backspace") event.preventDefault();
    })

    pval.addEventListener("change", function(){
        if(pval.value == 0) pval.value = 1;
    })

    pmin.addEventListener("click", function(){
        if(pval.value - 1 > 0) pval.value -= 1;
        else pval.value = 1;
        
    })

    padd.addEventListener("click", function(){
        pval.value = parseInt(pval.value) + 1;
    })

    form.addEventListener("reset", function(){
            padd.disabled=true;
            pmin.disabled=true;
            pval.disabled=true;
    })
}
