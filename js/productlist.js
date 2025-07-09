var submit = document.getElementById("orderForm");
var idArr = [];

fetch("../php/create_prod_list.php").
then(response=>response.json()).
then(data=>{
    //console.log(data);
    data.forEach(createProductList);
    submit.innerHTML += `<label><input type="radio" name="delivery" value="1">Delivery</label><br>
                        <label><input type="radio" name="delivery" value="0">On-Site</label><br>
                        <input type="submit" value="Submit Order"></input>`;

    localStorage.setItem("ListedIDs", JSON.stringify(idArr));
    console.log(localStorage.getItem("ListedIDs"));
    const event = new Event("ProductListGenerated");
    document.dispatchEvent(event);
})
function createProductList(item){
    submit.innerHTML += `<label for="p${item.ItemID}"><input type="checkbox" name="product[]" id="p${item.ItemID}" value="${item.ItemID}" class="ProdName">${item.ItemName}</label><br>

                        <label for="p${item.ItemID}val" >Number of Orders: </label>
                        <input type="button" value="+" id="p${item.ItemID}add" class="Prodadd">
                        <input type="text" name="product_amount[]" id="p${item.ItemID}val" class="ProdVal">
                        <input type="button" value="-" id="p${item.ItemID}min" class="ProdMin"><br>
                        `;
    idArr.push(item.ItemID)
}
