<?php
namespace App\Controllers;

class OrdersOperation extends BaseController{
    private function isReturnable($item_ids){
        $db = \Config\Database::connect();
        $table = $db->table('items');
        $val = false;
        foreach($item_ids as $id){
            $table->select("Returnable");
            $table->where("ItemID", $id, true);
            $result = $table->get();
            if( ($result->getRowArray())['Returnable'] == 1 ){
                $val = true;
                break;
            }
        }
        return $val;
    }

    private function inputValidate($user_chosen_products, $user_chosen_amount, $delivery){
        if(!(is_array($user_chosen_products) && is_array($user_chosen_amount))){
            if(session()->get('user_type') == "STAFF") return redirect()->to("/orders/staff/order")->with('message', "Product keys or amount is not an array");
            else return redirect()->to("/orders/cust/order")->with('message', "Product keys or amount is not an array");
        }
            

        if(empty($user_chosen_products) || empty($user_chosen_amount)){
            if(session()->get('user_type') == "STAFF") return redirect()->to("/orders/staff/order")->with('message', "Missing product keys or amount");
            else return redirect()->to("/orders/cust/order")->with('message', "Missing product keys or amount");
        }


        if(count($user_chosen_products) != count($user_chosen_amount)){
            if(session()->get('user_type') == "STAFF") return redirect()->to("/orders/staff/order")->with('message', "Product keys and amount mismatch");
            else return redirect()->to("/orders/cust/order")->with('message', "Product keys and amount mismatch");
        }


        if($delivery != 1 && $delivery != 0){
            if(session()->get('user_type') == "STAFF") return redirect()->to("/orders/staff/order")->with('message', "Delivery name corrupted");
            else return redirect()->to("/orders/cust/order")->with('message', "Delivery name corrupted");
        }
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

            if($this->isReturnable($user_products)){
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
            if(session()->get('user_type') == "STAFF") return redirect()->to("/orders/staff/order")->with('message', "There was a problem creating the order");
            else return redirect()->to("/orders/cust/order")->with('message', "There was a problem creating the order");
        }
        if(session()->get('user_type') == "STAFF") return redirect()->to("/orders/staff/order")->with('message', "Order Completed");
            else return redirect()->to("/orders/cust/order")->with('message', "Order Completed");
    }
}

?>