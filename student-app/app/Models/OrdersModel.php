<?php
namespace App\Models;
use CodeIgniter\Model;

class OrdersModel extends Model
{
    
    public function retOrdersJoined(){
        $db = \Config\Database::connect();
        $build = $db->table("orders");
        $build->select("orders.OrderID, users.UserID, users.FullName, itemnoimages.ItemID, itemnoimages.ItemName, order_details.ItemQuantity,
         orders.OrderDate, orders.TotalPrice, orders.Status");
        $build->join("order_details", "orders.OrderID = order_details.OrderID", "inner");
        $build->join("users", "users.UserID = orders.UserID", "inner");
        $build->join("itemnoimages", "itemnoimages.ItemID = order_details.ItemID", "inner");
        $build->orderBy("orders.OrderID", "ASC");
        $query = $build->get();
        $return = $query->getResultArray();
        return $return;

    }
}
?>