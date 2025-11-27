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
        return view("orders/signUpConfirmation");
        }else{
            return redirect()->to("/orders/signup")->with("message", "username or email already exists");
        }
    }

    public function gotoLogin() {
        return view('orders/login');
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

    public function verifyEdit(){
        $pass = $this->request->getPost('password');
        $res = $this->userModel->select('Password')
        ->where("UserID", session()->get('user_id'))
        ->first('array');

        if(password_verify($pass,$res['Password'])){
            return json_encode(true);
        }else return json_encode(false);
    }

    public function editUser(){
        $data = [
            'FullName' => $this->request->getPost('partnerName'),
            'Address' => $this->request->getPost('Address'),
            'Contact' => $this->request->getPost('contactNumber'),
            'Username' => $this->request->getPost('Username'),
            'Email' => $this->request->getPost('partnerEmail')
        ];
        
        $db = \Config\Database::connect();
        $table = $db->table('users');
        $table->where('UserID', session()->get('user_id'))
        ->update($data);

        return redirect()->to("orders/manageProf");
    }
////////////////////////////////////////////////////
    
}