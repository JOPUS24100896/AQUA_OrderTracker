var items = document.getElementById("Products");
var idArr = [];
var submit = document.getElementById("orderForm");

fetch("../php/create_prod_list.php").
    then(response => response.json()).
    then(data => {
        //console.log(data);
        data.forEach(createProductList);
        submit.innerHTML += `<div class="deliveryOptions"><label><input type="radio" name="delivery" value="1" class="orderHandling"> Delivery</label>
                                <label><input type="radio" name="delivery" value="0" class="orderHandling"> On-Site</label></div>
                                <input type="submit" value="Submit Order" class="orderHandling">`;

        localStorage.setItem("ListedIDs", JSON.stringify(idArr));
        console.log(localStorage.getItem("ListedIDs"));
        const event = new Event("ProductListGenerated");
        document.dispatchEvent(event);
    })
function createProductList(item) {
    items.innerHTML += `<div class="productCard"><img src="../php/viewImage.php?id=${item.ItemID}" alt="Product Image"><br><label for="p${item.ItemID}"><input type="checkbox" name="product[]" id="p${item.ItemID}" value="${item.ItemID}" class="ProdName"> ${item.ItemName}
                        </label> <br>

                        <label for="p${item.ItemID}val">Number of Orders:</label> <br>
                        <input type="button" value="-" id="p${item.ItemID}min" class="ProdMin"> 
                        <input type="text" name="product_amount[]" id="p${item.ItemID}val" class="ProdVal">
                        <input type="button" value="+" id="p${item.ItemID}add" class="Prodadd"><br></div>
                        
                        `;
    idArr.push(item.ItemID)
}
