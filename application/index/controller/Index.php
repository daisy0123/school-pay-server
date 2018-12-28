<?php
namespace app\index\controller;
use think\Request;
use think\Db;

define('CLASSMATCH', [0=>'图书音像',1 =>'日用百货',2=>'运动用具',3=>'精品服饰',4=>'手机数码',5=>'电脑网络',6=>'小巧电器']);

class Index {
  public function index() {
    $request = Request::instance();
    if ($request->isGet()) {
        $params = $request->get();
        $goodsclass = explode(",",$params['goodsclass']);
        $indexImg = 'http://localhost:8080/school-pay-server/public/indeximg/Python.jpg';
        foreach($goodsclass as $value){ 
           $dbResult = Db::table('sp_goods')->where('goodsclass',$value)->select();
           $data[$value] = ['goodsclass' => CLASSMATCH[$value],'goodsvalue'=>$value,'goodslist' => $dbResult];
        } 
        $result = ['state' => $this ->success(), 'data' => ['indexImg' => $indexImg, 'indexData' =>$data]];
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
