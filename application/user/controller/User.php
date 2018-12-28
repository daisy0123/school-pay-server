<?php
namespace app\user\controller;
use think\Request;
use think\Db;

class User {  
  public function register() {
    $request = request();
    if ($request->isPost()) {
        $user = $request->post();
        $username = $user['username'];
        $sex = $user['sex'];
        $phone = $user['phone'];
        $email = $user['email'];
        $password = $user['password'];
        $data = ['username' => $username, 'sex' => $sex, 'phone' => $phone, 'email' => $email, 'password' => $password];
        $dbResult = Db::table('sp_user')->insert($data);
        if ($dbResult) {
            $result =['state' => $this ->success()]; 
        }else {
            $result =['state' => $this ->error()]; 
        }
        return $result;
    } else if ($request->isGet()) {
       $uname = Db::table('sp_user')->column('username');
       $uphone = Db::table('sp_user')->column('phone');
       $uemail = Db::table('sp_user')->column('email');
       $result =['state' => $this ->success(), 'data' => ['uname' => $uname, 'uphone' => $uphone, 'uemail' => $uemail]];
       return $result;
    }
  }
  
  public function login () {
     $request = request();
     if ($request->isPost()) {
        $user = $request->post();
        $username = $user['username'];
        $password = $user['password'];
        $dbResult = Db::table('sp_user')->where('username',$username)->where('password',$password)->find();
        if ($dbResult) {
            $userData = ['isLogin' => true, 'userid' => $dbResult['userid'], 'username' => $username];
            $result =['state' => $this ->success(), 'data'=> $userData]; 
        }else {
            $result =['state' => $this ->success(), 'data'=> ['isLogin' => false]];  
        }
        return $result;
    } 
  }

  public function success () {
    return ['code' => 200, 'message' => '请求成功'];
  }
  
  public function error () {
    return ['code' => 500, 'message' => '服务器出错'];  
  }
}


