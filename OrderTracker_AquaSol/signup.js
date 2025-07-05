var formBody = document.getElementById("signupForm");
formBody.addEventListener("submit", function(event){
    event.preventDefault();
    var data = new FormData(formBody);
    fetch("signup.php", {
        method: 'POST',
        body: data
    }).
    then(response=>response.text()).
    then(data => {
        if(data.includes("Duplicate entry")){//Not-Unique username
            alert("Not unique username");
        }
        else {
            alert(data);
            window.location.assign("index.html");
        }
    })
})