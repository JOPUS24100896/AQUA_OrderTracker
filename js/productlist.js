var submit = document.getElementById("orderForm");
var idArr = [];

fetch("../php/create_prod_list.php").
then(response=>response.json()).
then(data=>{
    console.log(data);
    data.forEach(createProductList);
    submit.innerHTML += `<input type="checkbox"name="delivery"><label for="delivery">Delivery</label><br>
                        <input type="submit" value="Submit Order"></input>`;

    localStorage.setItem("ListedIDs", JSON.stringify(idArr));
    console.log(localStorage.getItem("ListedIDs"));
    const event = new Event("ProductListGenerated");
    document.dispatchEvent(event);
})
function createProductList(item){
    submit.innerHTML += `<input type="checkbox" name="product${item.ItemID}" id="p${item.ItemID}" value="Prod${item.ItemID}" class="ProdName"><label>${item.ItemName}</label><br>

                        <label for="product${item.ItemID}" >Number of Orders: </label>
                        <input type="button" value="+" id="p${item.ItemID}add" class="Prodadd">
                        <input type="text" name="${item.ItemID}" id="p${item.ItemID}val" class="ProdVal">
                        <input type="button" value="-" id="p${item.ItemID}min" class="ProdMin"><br>
                        `;
    idArr.push(item.ItemID)
}
