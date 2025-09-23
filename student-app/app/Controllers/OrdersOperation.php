<?php
namespace App\Controllers;

class OrdersOperation extends BaseController{
//     $user_chosen_products = isset($_POST["product"])?$_POST["product"]:null;
// $user_chosen_amount = isset($_POST["product_amount"])?$_POST["product_amount"]:null;
// $user_id = $_SESSION["user_id"];
// $item_ids = implode(',', $user_chosen_products);
// $item_values = implode(',', $user_chosen_amount);
// $prod_selected = [];
// $prod_values = [];
// $delivery = (int) $_POST["delivery"];
// $address = isset($_POST["address"]) ? $_POST["address"] : null;

    private function isReturnable($item_ids){
        $db = \Config\Database::connect();
        $query = $db->query("SELECT return_deadline_needed(?) AS deadline_bool;", [$item_ids]);
        $result = $query->getRowArray();
        return $result['deadline_bool'];
    }

    private function inputValidate($user_chosen_products, $user_chosen_amount, $delivery){
        if(!(is_array($user_chosen_products) && is_array($user_chosen_amount)))
            return redirect()->to("/orders")->with('message', "Product keys or amount is not an array");

        if(empty($user_chosen_products) || empty($user_chosen_amount))
            return redirect()->to("/orders")->with('message', "Missing product keys or amount");


        if(count($user_chosen_products) != count($user_chosen_amount))
            return redirect()->to("/orders")->with('message', "Product keys and amount mismatch");


        if($delivery != 1 && $delivery != 0)
            return redirect()->to("/orders")->with('message', "Delivery name corrupted");

        return false;
    }



    public function makeOrder(){
        $user_products = $this->request->getPost("product");
        $user_chosen_amount = $this->request->getPost("product_amount");
        $delivery = (session()->get('user_type') == "STAFF")?0:(int) $this->request->getPost("delivery");
        $return_id = NULL;
        $delivery_id = NULL;

        $invalid = $this->inputValidate($user_products, $user_chosen_amount, $delivery);
        if($invalid){
            return $invalid;
        }


        $db = \Config\Database::connect();
        $db->transStart();

            if($this->isReturnable(implode(",", $user_chosen_amount))){
                $db->query("INSERT INTO return_deadlines VALUES (default, DATE_ADD(NOW(), INTERVAL 5 DAY), default);");
                $return_id = $db->insertID();
            }
            if($delivery == 1){
                $db->query("INSERT INTO deliveries VALUES (DEFAULT, DEFAULT, DEFAULT, DEFAULT);");
                $delivery_id = $db->insertID();
            }

            $db->query("CALL return_total_price(? ,? , @total_price)", [implode(",", $user_products), implode(',', $user_chosen_amount)]);
            $priceRow = $db->query("SELECT @total_price AS total_price");
            $totalPrice = ($priceRow->getRowArray())['total_price'];

            $db->query("INSERT INTO orders 
                        (OrderID, UserID, ReturnDeadlineID, DeliveryID, Status, TotalPrice, OrderDate)
                        VALUES 
                        (DEFAULT, ?, ?, ?, DEFAULT, ? , DEFAULT)", [session()->get('user_id'), $return_id, $delivery_id, $totalPrice]);
            $order_id = $db->insertID();
            foreach($user_products as $ndx => $val){
                $db->query("INSERT INTO order_details VALUES (default, ?, ?, ?);",[$val, $order_id, $user_chosen_amount[$ndx]]);
            }

        $db->transComplete();
        if($db->transStatus()){
            return redirect()->to("/orders")->with('message', "There was a problem creating the order");
        }
        return redirect()->to("/orders")->with('message', "Order completed");
    }
}

?>