var forms = document.getElementById("content");
var login_key = document.getElementById("email_or_phone");
var pass_key = document.getElementById("password_input");

forms.addEventListener("submit", function(event){
    event.preventDefault();
    alert("check1");
    const formsData = new FormData(this);
    fetch("../php/login.php", {
        method: 'POST',
        body: formsData
    }).
    then(response=>response.json()).
    then(data => {
        console.log(data);
        if(!data.Error){
            switch(data.Type) {
                case "CUST":
                    window.location.assign("../customer UI/CreateOrder.html");
                break;
                case "ADMIN":
                    window.location.assign("../admin UI/InventoryUI.html");
                break;
                case "STAFF":
                    window.location.assign("../staff UI/ManageOrders.html");
                break;
            }
            
        }else{
            errorVerification();    
        }
    }).catch(data => {
        console.log(JSON.stringify(data))
    })
})

function errorVerification(){
    login_key.style.border = "1px solid red";
    pass_key.style.border = "1px solid red";
}
