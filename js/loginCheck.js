fetch("../php/login_check.php"). 
then(res => res.json()). 
then(data => {
    console.log(data);
    if(data.Error_Number == "Login"){
                switch(data.Error_Location){
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
            }
})