<?php
namespace App\Controllers;
use App\Models\ProductModel;

class OrderViews extends BaseController
{
    protected $productModel;
    
    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

//----------------GENERAL---------------
    public function index()
    {
        $session = session();
        $this->response->setHeader("Cache-Control", "no-store, no-cache, must-revalidate, max-age=0");
        $this->response->setHeader("Pragma", "no-cache");
        $this->response->setHeader("Expires", "Sat, 26 Jul 1997 05:00:00 GMT");

        if(null !== $session->get("user_id")){
            switch($session->get("user_type")){
                case "STAFF":
                    return redirect()->to("orders/staff/manageOrders");
                break;
                case "CUST":
                    return redirect()->to("orders/cust/order");
                break;
                case "ADMIN":
                    return redirect()->to("orders/admin/orderGraph");
                break;
            }
        }
        else
        return view('orders/index');
    }

    public function contactInfo()
    {
        return view('orders/ContactInfo');
    }

    public function privPolicy()
    {
        return view('orders/PrivacyPolicy');
    }

    public function signUp(){
        return view('orders/SignUp');
    }

    public function endSession(){
    session()->destroy();
    return redirect()->to("/orders");
    }

    public function manageProf(){
        $data['url'] = "manageProf";
        $data['user_type'] = session()->get("user_type");
        switch(session()->get("user_type")){
            case "CUST":
            case "ADMIN":
            case "STAFF":
                $db = \Config\Database::connect();
                $table = $db->table('users');
                $table->select('FullName, Address, Contact, Username, Email');
                $table->where('UserID', session()->get('user_id'));
                $data['data'] = $table->get()->getRowArray();
                return view('orders/ManageProfile', $data);
            break;
            default:
                return redirect()->to("/orders");
            break;
        }
        
    }
//---------------CUST----------------
    public function makeOrderCust(){
        $data['url'] = "order";

        switch(session()->get("user_type")){
            case "CUST":
                $db = \Config\Database::connect();
                $build = $db->table("items");
                $build->select("*");

                $query = $build->get();
                $return = $query->getResultArray();

                $data["data"] = $return;

                return view('orders/customerUI/CreateOrder', $data);
            break;
            default:
                return redirect()->to("/orders");
            break;
        }
        
    }

    public function orderHistoryCust(){
        $data['url'] = "pending";
        switch(session()->get("user_type")){
            case "CUST":
                $db = \Config\Database::connect();
                $build = $db->table("orders");
                $build->select("orders.OrderID, itemnoimages.ItemName, itemnoimages.Price, 
                orders.OrderDate, orders.TotalPrice, order_details.ItemQuantity, orders.Status");
                $build->join("order_details", "orders.OrderID = order_details.OrderID", "inner");
                $build->join("itemnoimages", "itemnoimages.ItemID = order_details.ItemID", "inner");
                $build->where("orders.UserID", session()->get("user_id"), true);
               $build->whereIn("orders.Status", ["Pending", "Transit"]);
                $query = $build->get();
                $return = $query->getResultArray();

                $data["data"] = $return;
                return view('orders/customerUI/Orders', $data);
            break;
            default:
                return redirect()->to("/orders");
            break;
        }
        
    }

     public function allOrdersCust(){
        $data['url'] = "history";

        switch(session()->get("user_type")){
            case "CUST":
                $db = \Config\Database::connect();
                $build = $db->table("orders");
                $build->select("orders.OrderID, itemnoimages.ItemName, order_details.ItemQuantity, itemnoimages.Price, 
                orders.OrderDate, orders.TotalPrice, orders.Status");
                $build->join("order_details", "orders.OrderID = order_details.OrderID", "inner");
                $build->join("itemnoimages", "itemnoimages.ItemID = order_details.ItemID", "inner");
                $build->where("orders.UserID", session()->get("user_id"));
                $build->orderBy("orders.OrderDate", "DESC");
                $query = $build->get();
                $return = $query->getResultArray();


                $data["data"] = $return;
                return view('orders/customerUI/OrderHistory', $data);
            break;
            default:
                return redirect()->to("/orders");
            break;
        }
    }

//------------STAFF---------------
    
    public function manageOrders(){
        $data['url'] = "manageOrders";
        
        
        switch(session()->get("user_type")){
            case "STAFF":
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


                $data["data"] = $return;
                return view("orders/staffUI/ManageOrders", $data);
            break;
            default:
                return redirect()->to("/orders");
            break;
        }
        
    }

    public function orderRecStaff(){
        $data['url'] = "orderRec";        

        switch(session()->get("user_type")){
            case "STAFF":
                $db = \Config\Database::connect();
                $build = $db->table("orders");
                $build->select("orders.OrderID, users.UserID, users.FullName, itemnoimages.ItemID, itemnoimages.ItemName, order_details.ItemQuantity,
                orders.OrderDate, orders.TotalPrice, orders.Status");
                $build->join("order_details", "orders.OrderID = order_details.OrderID", "inner");
                $build->join("users", "users.UserID = orders.UserID", "inner");
                $build->join("itemnoimages", "itemnoimages.ItemID = order_details.ItemID", "inner");
                $build->orderBy("orders.OrderID", "ASC");
                $build->where("users.UserID", session()->get("user_id"), true);
                $query = $build->get();
                $return = $query->getResultArray();

                $data["data"] = $return;
                return view("orders/staffUI/OrderRecordStaff", $data);
            break;
            default:
                return redirect()->to("/orders");
            break;
        }
    }
    
    public function makeOrderStaff(){
        $data['url'] = "order";
        switch(session()->get("user_type")){
            case "STAFF":
                $db = \Config\Database::connect();
                $build = $db->table("items");
                $build->select("*");

                $query = $build->get();
                $return = $query->getResultArray();

                $data["data"] = $return;
                return view("orders/staffUI/MakeAnOrder", $data);
            break;
            default:
                return redirect()->to("/orders");
            break;
        }
        
    }

    public function deliv(){
        $data['url'] = "deliveries";

        
        switch(session()->get("user_type")){
            case "STAFF":
                $db = \Config\Database::connect();
            $build = $db->table("orders");
            $build->select("orders.OrderID, orders.OrderDate, users.UserID, users.Username, orders.TotalPrice,
            orders.Status, delivery_port.PortID, delivery_port.PortNumber, deliveries.DeliveryID, deliveries.DeliveryStatus");
            $build->join("users", "users.UserID = orders.UserID", "inner");
            $build->join("deliveries", "orders.DeliveryID = deliveries.DeliveryID", "inner");
            $build->join("delivery_port", "deliveries.PortID = delivery_port.PortID", "left");
            $build->where("orders.Status !=", "'Pending'");
            $query = $build->get();
            $return = $query->getResultArray();
            $data['data'] = $return;
                return view("orders/staffUI/Deliveries", $data);
            break;
            default:
                return redirect()->to("/orders");
            break;
        }
        
    }
//-------------ADMIN-----------------

// $routes->get('orders/admin/inventory', 'OrderViews::inventoryAdmin');
// $routes->get('orders/admin/orderGraph', 'OrderViews::orderGraphAdmin');
// $routes->get('orders/admin/orderRecord', 'OrderViews::orderRecordAdmin');

    public function inventoryAdmin(){
        $data['url'] = "inventory";
        switch(session()->get("user_type")){
            case "ADMIN":
                return view("orders/adminUI/InventoryUI", $data);
            break;
            default:
                return redirect()->to("/orders");
            break;
        }
    }

    public function orderGraphAdmin(){
        $data['url'] = "orderGraph";
        switch(session()->get("user_type")){
            case "ADMIN":
                return view("orders/adminUI/OrderGraph", $data);
            break;
            default:
                return redirect()->to("/orders");
            break;
        }
    }

    public function orderRecordAdmin(){
        $data['url'] = "orderRecord";
        switch(session()->get("user_type")){
            case "ADMIN":
                return view("orders/adminUI/OrderRecord", $data);
            break;
            default:
                return redirect()->to("/orders");
            break;
        }
    }
///////////////////////////////////////////////////////
    public function store()
    {
        if($this->request->getPost('price') < 0){
            $data["message"] = "Price is invalid!";
            return view("products/create", $data);
        }

        if($this->productModel->where('name', $this->request->getPost('name'))->first()){
            $data["message"] = "Product name already exists!";
            return view("products/create", $data);
        }

        $this->productModel->save([
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price')
        ]);

        return redirect()->to('/products')->with('message', 'Product added successfully!');
        
        
    }  
    
    public function delData()
    {
        $data['products'] = $this->productModel->findAll();
        return view('products/delete', $data);
    }


    public function delete(){
        $ids = $this->request->getPost('idDel');
        foreach($ids as $n){
            if($this->productModel->find($n)){
                $this->productModel->delete($n);
            }
        }

        return redirect()->to('/products')->with('message', 'Product deleted successfully!');

    }
}