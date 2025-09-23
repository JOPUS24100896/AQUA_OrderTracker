<?php
namespace App\Controllers;
use App\Models\ProductModel;

class Products extends BaseController
{
    protected $productModel;
    
    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $data['products'] = $this->productModel->findAll();
        return view('products/index', $data);
    }

    public function create()
    {
        return view('products/create');
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