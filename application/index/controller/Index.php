<?php
namespace app\index\controller;
use think\Request;

class Index {
  public function index() {
    $request = Request::instance();
    if ($request->isGet()) {
        $data = ['state' => ['code' => 200, 'message' => 'ok'], 'data' => 'ok'];
        return $data;
    }
  }
}
