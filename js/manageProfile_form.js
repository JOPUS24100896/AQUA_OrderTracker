const submitForm = document.getElementById("profileForm");
const after_submit = document.getElementById("verifyDiv");
const verifySubmit = document.getElementById("verifyForm");
const back_Submit = document.getElementById("backForm");
const errFeedback = document.getElementById("errFeedback");
submitForm.addEventListener("submit", function(event){
    event.preventDefault();
    after_submit.removeAttribute("hidden");
    submitForm.setAttribute("hidden", "");
});

submitForm.addEventListener("GoodVerification", function(){
    let formData = new FormData(this);
    fetch("../php/update_profile.php", {
        method: "POST",
        body: formData
    }).
    then(res=>res.json()).
    then(data => {
        console.log(data);
        if(!data.Error) location.reload();
        else {
            errFeedback.removeAttribute("hidden");
            errFeedback.innerHTML = data.Error_Message;
        }
    })
});

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
    verify.append("login_key", Username);
    fetch("../php/login.php", {
        method: 'POST',
        body: verify
    }).
    then(res=>res.json()). 
    then(data => {
        console.log(data);
        if(!data.Error){
            let newEvent = new Event("GoodVerification");
            submitForm.dispatchEvent(newEvent);
        }else {
            errFeedback.removeAttribute("hidden");
            errFeedback.innerHTML = "Password is incorrect";
        }
    });
});