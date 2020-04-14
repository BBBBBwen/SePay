<?php
namespace app\index\model;
class User{
    private $email;
    private $password;

    public function __construct($email,$password){
        $this->email = $email;
        $this->password = $password;
    }

    public function GetEmail(){
        return $this->email;
    }

    public function GetPassword(){
        return $this->password;
    }
}