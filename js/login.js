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
            window.location.assign("../CreateOrder.html");
        }else{
            errorVerification();    
        }
    })
})

function errorVerification(){
    login_key.style.border = "1px solid red";
    pass_key.style.border = "1px solid red";
}
