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
        $this->response->setHeader("Expires", "0");

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
        $data['url'] = "PrivacyPolicy";
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
                return view('orders/PrivacyPolicy', $data);
            break;
            default:
                return redirect()->to("/orders");
            break;
        }
    }

    public function gotoLogin()
    {   
        $session = session();
        $this->response->setHeader("Cache-Control", "no-store, no-cache, must-revalidate, max-age=0");
        $this->response->setHeader("Pragma", "no-cache");
        $this->response->setHeader("Expires", "0");

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
        return view('orders/LogIn'); 
    }

    public function signUp(){
        $session = session();
        $this->response->setHeader("Cache-Control", "no-store, no-cache, must-revalidate, max-age=0");
        $this->response->setHeader("Pragma", "no-cache");
        $this->response->setHeader("Expires", "0");

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
                $build->select("orders.OrderID, items.ItemName, items.Price, 
                orders.OrderDate, orders.TotalPrice, order_details.ItemQuantity, orders.Status");
                $build->join("order_details", "orders.OrderID = order_details.OrderID", "inner");
                $build->join("items", "items.ItemID = order_details.ItemID", "inner");
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
                $build->select("orders.OrderID, items.ItemName, order_details.ItemQuantity, items.Price, 
                orders.OrderDate, orders.TotalPrice, orders.Status");
                $build->join("order_details", "orders.OrderID = order_details.OrderID", "inner");
                $build->join("items", "items.ItemID = order_details.ItemID", "inner");
                $build->where("orders.UserID", session()->get("user_id"));
                $build->orderBy("orders.OrderDate", "DESC");
                
                //this is the function
                $itemFilter = $this->request->getGet('item'); 
                $searchField = $this->request->getGet('field');
                $searchValue = $this->request->getGet('search');

                if (!empty($itemFilter) && strtolower($itemFilter) !== 'all') {
                    $build->where('items.ItemName', $itemFilter);
                }
               
                 if (!empty($searchField) && !empty($searchValue)) {
                    $allowedFields = ['orders.OrderID', 'orders.OrderDate'];
                    if (in_array($searchField, $allowedFields)) {
                        $build->like($searchField, $searchValue);
                    }
                }

                $query = $build->get();
                $return = $query->getResultArray();

                $data["data"] = $return;
                $data['itemFilter']   = $itemFilter; 
                $data['searchField']  = $searchField;
                $data['searchValue']  = $searchValue;
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
                $build->select("orders.OrderID, users.UserID, users.FullName, items.ItemID, items.ItemName, order_details.ItemQuantity,
                orders.OrderDate, orders.TotalPrice, orders.Status");
                $build->join("order_details", "orders.OrderID = order_details.OrderID", "inner");
                $build->join("users", "users.UserID = orders.UserID", "inner");
                $build->join("items", "items.ItemID = order_details.ItemID", "inner");
                
                $searchField = $this->request->getGet('field');
                $itemFilter = $this->request->getGet('item'); 
                $searchValue = $this->request->getGet('search');
                
                if (!empty($itemFilter) && strtolower($itemFilter) !== 'all') {
                    $build->where('items.ItemName', $itemFilter);
                }
                
                if (!empty($searchField) && !empty($searchValue)) {
                    $allowedFields = ['orders.OrderID', 'orders.OrderDate'];
                    if (in_array($searchField, $allowedFields)) {
                        $build->like($searchField, $searchValue);
                    }
                }

                $build->orderBy("orders.OrderID", "ASC");
                // $build->where("users.UserID", session()->get("user_id"), true);

                $query = $build->get();
                $return = $query->getResultArray();

                $data["data"] = $return;
                $data['itemFilter']   = $itemFilter; 
                 $data['searchField']  = $searchField;
                $data['searchValue']  = $searchValue;
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
                $build->select(
                    "orders.OrderID, 
                    users.UserID, 
                    users.FullName, 
                    items.ItemID, 
                    items.ItemName, 
                    order_details.
                    ItemQuantity,
                    orders.OrderDate, 
                    orders.TotalPrice, 
                    orders.Status");
                $build->join("order_details", "orders.OrderID = order_details.OrderID", "inner");
                $build->join("users", "users.UserID = orders.UserID", "inner");
                $build->join("items", "items.ItemID = order_details.ItemID", "inner");
                
                $searchField = $this->request->getGet('field');
                $searchValue = $this->request->getGet('search');
                $itemFilter = $this->request->getGet('item'); 
           
                if (!empty($itemFilter) && strtolower($itemFilter) !== 'all') {
                    $build->where('items.ItemName', $itemFilter);
                }
                
                if (!empty($searchField) && !empty($searchValue)) {
                    $allowedFields = ['orders.OrderID', 'orders.OrderDate'];
                    if (in_array($searchField, $allowedFields)) {
                        $build->like($searchField, $searchValue);
                    }
                }

                $build->orderBy("orders.OrderID", "ASC");
                $build->where("users.UserID", session()->get("user_id"), true);
                
                $query = $build->get();
                $return = $query->getResultArray();

                $data['data'] = $return;
                $data['itemFilter']   = $itemFilter; 
                $data['searchField']  = $searchField;
                $data['searchValue']  = $searchValue;
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
            $build->select("orders.OrderID, orders.OrderDate, users.UserID, users.FullName, orders.TotalPrice,
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



    public function inventoryAdmin(){
        $data['url'] = "inventory";
        switch(session()->get("user_type")){
            case "ADMIN":
                $db = \Config\Database::connect();
                $builder = $db->table('items');

                  $builder = $db->table('items');
                $builder->select('ItemID, ImagePath, ItemName, StockQuantity');

                $query = $builder->get();
                $Inventory = $query->getResultArray();

                $data['Inventory'] = $Inventory;
                return view("orders/adminUI/InventoryUI", $data);
            break;
            default:
                return redirect()->to("/orders");
            break;
        }
    }
    public function addStock()
    {
        header("Access-Control-Allow-Origin: *");
        $request = $this->request->getJSON();
        $itemId = $request->ItemID ?? null;
        $addedStock = $request->AddedStock ?? null;

        if ($itemId && $addedStock) {
            $db = \Config\Database::connect();
            $builder = $db->table('items');

            // Fetch current stock
            $item = $builder->where('ItemID', $itemId)->get()->getRowArray();

            if ($item) {
                $newQty = $item['StockQuantity'] + $addedStock;
                $builder->where('ItemID', $itemId)
                        ->update(['StockQuantity' => $newQty]);
                return $this->response->setJSON([
                    "success" => true,
                    "message" => "Stock updated successfully."
                ]);
            } else {
                return $this->response->setJSON([
                    "success" => false,
                    "message" => "Item not found."
                ]);
            }
        } else {
            return $this->response->setJSON([
                "success" => false,
                "message" => "Invalid input."
            ]);
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
    
    public function graphData()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('orders.OrderID, orders.OrderDate, order_details.ItemID, items.ItemName');
        $builder->join('order_details', 'order_details.OrderID = orders.OrderID', 'inner');
        $builder->join('items', 'items.ItemID = order_details.ItemID', 'inner');
        $query = $builder->get();
        $orders = $query->getResultArray();
        return $this->response->setJSON($orders);
    }


    public function orderRecordAdmin(){
        $data['url'] = "orderRecord";
        switch(session()->get("user_type")){
            case "ADMIN":
                $db = \Config\Database::connect();
                $builder = $db->table('orders');
                $builder->select(
                    'orders.OrderID as ID, ' .
                    'items.ItemName as ItemName, ' .    
                    'order_details.ItemQuantity as ItemQuantity, ' .
                    'items.Price as Price, ' .
                    'orders.OrderDate as OrderDate, ' .
                    '(order_details.ItemQuantity * items.Price) as TotalPrice'
                );
                $builder->join('order_details', 'order_details.OrderID = orders.OrderID', 'inner');
                $builder->join('items', 'items.ItemID = order_details.ItemID', 'inner');
               


                //this is the function
                $itemFilter = $this->request->getGet('item'); // e.g. ?item=Router
                if (!empty($itemFilter) && strtolower($itemFilter) !== 'all') {
                    $builder->where('items.ItemName', $itemFilter);
                }
               
                $searchField = $this->request->getGet('field');
                $searchValue = $this->request->getGet('search');

                 if (!empty($searchField) && !empty($searchValue)) {
                    $allowedFields = ['orders.OrderID', 'orders.OrderDate'];
                    if (in_array($searchField, $allowedFields)) {
                        $builder->like($searchField, $searchValue);
                    }
                }

                $builder->orderBy('order_details.OrderDetailID', 'DESC');

                $query = $builder->get();
                $orderRecords = $query->getResultArray();

                $data['orderRecords'] = $orderRecords;
                $data['itemFilter']   = $itemFilter; 
                $data['searchField']  = $searchField;
                $data['searchValue']  = $searchValue;

                return view("orders/adminUI/OrderRecord", $data);
            break;  
            default:
                return redirect()->to("/orders");
            break;
        }
    }
 
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