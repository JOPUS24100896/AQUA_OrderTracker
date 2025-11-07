<?php
namespace App\Controllers;

class OrdersOperation extends BaseController{

//----------------------MAKE ORDERS--------------------
    private function haveDuplicateOrder(){
        $db = \Config\Database::connect();
        $table = $db->table("orders");
        $table->select("1");
        $table->where("UserID", session()->get('user_id'), true);
        $table->whereNotIn("Status", ["Cancelled", "Complete"]);

        if( $table->get()->getRowArray() )
           return redirect()->to("/orders/cust/order")->with('message', "Only one order at a time");
        
        return false;
    }

    private function isReturnable($item_ids){
        $db = \Config\Database::connect();
        $table = $db->table('items');
        foreach($item_ids as $id){
            $table->select("Returnable");
            $table->where("ItemID", $id, true);
            $result = $table->get();
            if( ($result->getRowArray())['Returnable'] == 1 ) return true;
        }
        return false;
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

        $duplicate = (session()->get('user_type') == 'CUST')? $this->haveDuplicateOrder():false;
        if($duplicate) return $duplicate;

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
        if(!$db->transStatus()){
            if(session()->get('user_type') == "STAFF") return redirect()->to("/orders/staff/order")->with('message', "There was a problem creating the order");
            else return redirect()->to("/orders/cust/order")->with('message', "There was a problem creating the order");
        }
        if(session()->get('user_type') == "STAFF") return redirect()->to("/orders/staff/order")->with('message', "Order Completed");
            else return redirect()->to("/orders/cust/order")->with('message', "Order Completed");
    }

//-----------------UPDATE ORDER STATUS----------------------
    private function isOrderCancelled($id){
        $db = \Config\Database::connect();
        $table = $db->table("orders");
        $table->select("1");
        $table->where("OrderID", $id, true);
        $table->where("Status", "Cancelled", true);
        
        if( $table->get()->getRowArray() ) 
            return redirect()->to("/orders/staff/manageOrders")->with("message", "Order was cancelled by customer");
        return false;
    }

    public function updateStatus(){
        $id = (int) $this->request->getPost('OrderID');
        $status = $this->request->getPost('Status');
        $isCancelled = $this->isOrderCancelled($id);
        if( $isCancelled ) return $isCancelled;
        $db = \Config\Database::connect();
        $db->transStart();
            $db->query("CALL update_order_status(?,?)", [$status, $id]);
        $db->transComplete();
        if(!$db->transStatus()) return redirect()->to("/orders/staff/manageOrders")->with("message", ["There was a problem processing the request",(string) $id]);
        
        return redirect()->to("/orders/staff/manageOrders")->with("message", ["Status updated", (string) $id]);
    }
//-------------------UPDATE PORT-----------------
    private function isDeliveryCancelled($delId){
        $db = \Config\Database::connect();
        $table = $db->table("deliveries");
        $table->select("1");
        $table->where("DeliveryID", $delId);
        $table->where("DeliveryStatus", "Cancelled");
        
        if( $table->get()->getRowArray() ) 
            return redirect()->to("/orders/staff/deliveries")->with("message", "Order was cancelled by customer");
        return false;
    }

    private function updateDelPort($portId, $DelId){
        $db = \Config\Database::connect();
        $db->query("CALL update_port_status(?,?, @message)", [$portId, $DelId]);
        $messageRow = $db->query("SELECT @message AS 'message'");
        $message = ($messageRow->getRowArray()) ['message'];
        return $message;
    }

    private function updatePortStatus($status, $DelId){
        $db = \Config\Database::connect();
        $db->query("CALL update_delivery_status(?,?, @message)", [$status, $DelId]);
        $messageRow = $db->query("SELECT @message AS 'message'");
        $message = ($messageRow->getRowArray()) ['message'];
        return $message;
    }

    public function updateDelivery(){
        $delId = (int) $this->request->getPost('DeliveryID');
        $style = ".orderNumber".(string) $delId." {background-color: #e0f7fa;}";
        $isCancelled = $this->isDeliveryCancelled($delId);
        if( $isCancelled ) return $isCancelled;

        if($portId = $this->request->getPost('PortID')){
            $message = $this->updateDelPort($portId, $delId);
            return redirect()->to('/orders/staff/deliveries')->with('message', [$message, $style]);
        }else if($status = $this->request->getPost('Status')){
            $message = $this->updatePortStatus($status, $delId);
            return redirect()->to('/orders/staff/deliveries')->with('message', [$message, $style]);
        }

        return redirect()->to('/orders/staff/deliveries')->with('message', ["Please choose an option", $style]);
    }

    public function cancelOrder(){
        $db = \Config\Database::connect();
        $table = $db->table("orders")
        ->select("OrderID")
        ->where("UserID", session()->get('user_id'))
        ->whereIn("Status", ["Pending", "Transit"]);
        $orderId = $table->get()->getRowArray();

        $update = ['Status' => "Cancelled"];
        $db->table("orders")->where("OrderID", $orderId["OrderID"])->update($update);
        return redirect()->to("/orders/cust/pending")->with("message", "Order has been cancelled");
    }
}

?>