<?php
namespace App\Controllers;
use App\Models\UserModel;

class AccountManagement extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function signUp(){
        
        $username = $this->request->getPost("username");
        $email = $this->request->getPost("email");
        $pass = password_hash($this->request->getPost("password"), PASSWORD_DEFAULT);
        $fullname = $this->request->getPost("fullname");
        $address = $this->request->getPost("address");
        $contact = $this->request->getPost("contact");
        $check = $this->userModel->builder("users")->orWhere([
            'Username' => $username,
            'Email' => $email
        ])->get()->getFirstRow();

        if(is_null($check)){
            $this->userModel->save([
                'FullName' => $fullname,
                'Address' => $address,
                'Contact'=> $contact,
                'Username' => $username,
                'Email' => $email,
                'Password' => $pass,
                'Type' => 'CUST',
        ]);
        return redirect()->to("/orders");
        }else{
            $data["message"] = "username or email already exists";
            return view("orders/SignUp", $data);
        }
    }

    public function login(){
        $username = $this->request->getPost("login_key");
        $pass = $this->request->getPost("password");

        $res = $this->userModel->where("Username", $username)->orWhere("Email", $username)->first('array');
        if(!is_null($res)){
            if(password_verify($pass, $res["Password"])){
                $session = session();
                $session->set("user_id", $res["UserID"]);
                $session->set("user_type", $res["Type"]);
                return redirect()->to('/orders');
            }else{
                return view("orders/signup");
            }
        }else{
        return view("orders/signup");
        }
        
    }
////////////////////////////////////////////////////
    
}