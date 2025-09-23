var formBody = document.getElementById("signupForm");
formBody.addEventListener("submit", function(event){
    event.preventDefault();
    var data = new FormData(formBody);
    fetch("../php/signup.php", {
        method: 'POST',
        body: data
    }).
    then(response=>response.json()).
    then(data => {
        if(data.Error){//Not-Unique username
            console.log(data);
            alert(data.Error_Message);
        }
        else {
            console.log(data);
            alert("Sign Up complete");
            window.location.assign("index.php"); 
        }
    })
})