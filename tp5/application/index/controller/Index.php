<?php
namespace app\index\controller;
use app\index\model\User;
use think\Db;

class Index
{
    public function index()
    {
        return view();
    }

    public function loginview() {
        return view();
    }

    public function registerview() {
        return view();
    }

    public function homepageview() {
        return view();
    }

    public function login(){
        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = new User($email,$password);

        $val = Db::table('users')
            ->where('email',$user->GetEmail())
            ->where('password',$user->GetPassword())
            ->find();

        $msg = "";
        if($val){
            $_SESSION["user"] = $user->GetName();
            $msg = "login successed";
        }else{
            $msg = "login failed";
        }
        return $msg;
    }

    public function register(){
        $email = $_POST["email"];
        $password = $_POST["password"];
        $name = $_POST['username'];
        $avatar = ('image/'.$_FILES['avatar']['name']);

        $user = new User($email,$password);

        $val = Db::table('users')
            ->where('email',$user->GetEmail())
            ->find();

        $msg = "";
        if($val){
            $msg = "register filed";
        }else{
            $data = ['username' => $name, 'password' => $user->GetPassword(),
                'email' => $user->GetEmail(), 'avatar' => $avatar];
            Db::table('users')->insert($data);

            $msg = "register successed";
        }
        return $msg;
    }
}
?>