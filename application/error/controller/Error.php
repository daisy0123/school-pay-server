<?php
namespace app\error\controller;

class Error {
  public function index() {
    $error = ['statusName'=>'资源未找到','status'=>404];
    return $error;
  }
}