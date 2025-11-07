const submitForm = document.getElementById("profileForm");
const after_submit = document.getElementById("verifyDiv");
const verifySubmit = document.getElementById("verifyForm");
const back_Submit = document.getElementById("backForm");
const errFeedback = document.getElementById("errFeedback");
const namefull = document.getElementById('name');
const email = document.getElementById('email');
const username = document.getElementById('username');
const cont = document.getElementById('cont');
const address = document.getElementById('addr');
const edit = document.getElementById("edit");

submitForm.addEventListener("submit", function(event){
    alert("123");
    event.preventDefault();
    after_submit.removeAttribute("hidden");
    submitForm.setAttribute("hidden", "");
});

edit.addEventListener("click", function(event){
    event.preventDefault();
    address.disabled = !address.disabled;
    cont.disabled = !cont.disabled;
    username.disabled = !username.disabled;
    email.disabled = !email.disabled;
    namefull.disabled = !namefull.disabled;
})

back_Submit.addEventListener("click", function(){
    verifySubmit.reset();
    
    submitForm.removeAttribute("hidden");
    after_submit.setAttribute("hidden", "");
    errFeedback.setAttribute("hidden", "");
    errFeedback.innerHTML = "";
});

verifySubmit.addEventListener("submit", function(event){
    event.preventDefault();
    let verify = new FormData(this);
    fetch(base + "orders/verifyPass", {
        method: 'POST',
        body: verify
    }).
    then(res=>res.json()). 
    then(data => {
        if(data){
            //let newEvent = new Event("GoodVerification");
            errFeedback.hidden = !errFeedback.hidden;
            submitForm.submit();
            //errFeedback.innerHTML = "Password is correct";
        }else{
            errFeedback.removeAttribute("hidden");
            errFeedback.innerHTML = "Password is incorrect";
        }
    });
});