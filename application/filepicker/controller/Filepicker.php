<?php

namespace app\filepicker\controller;

use think\Request;
use think\File;

define("PATH", "http://localhost:8080/school-pay-server/public/");

class Filepicker {

    public function DetailImage(Request $request) {
        $files = request()->file('details');
        $path = PATH.'detailimg/';
        foreach ($files as $file) {
            $info = $file->move(ROOT_PATH . 'public' . DS . 'detailimg');
            if ($info) {
                $result = ['state' => $this->success(), 'data' => ['url' => $path . $info->getSaveName(), 'name' => $info->getFilename()]];
            } else {
                $result = ['state' => $this->error()];
            }
        }
        return $result;
    }
    
    public function CoverImage(Request $request) {
        $file = request()->file('cover');
        $path = PATH.'coverimg/';
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'coverimg');
            if ($info) {
                $result = ['state' => $this->success(), 'data' => ['url' => $path . $info->getSaveName(), 'name' => $info->getFilename()]];
            } else {
                $result = ['state' => $this->error()];
            }
        }
        return $result;
    }

    public function UserImage() {
        $request = request();
        if ($request->isPost()) {
            $file = $request->post();
            $result = ['state' => $this->success(), 'data' => $file];
        } else {
            $result = '上传file';
        }
        return $result;
    }

    public function success() {
        return ['code' => 200, 'message' => '请求成功'];
    }

    public function error() {
        return ['code' => 500, 'message' => '服务器出错'];
    }

}
