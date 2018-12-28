<?php

namespace app\shop\controller;

use think\Request;
use think\Db;

class Shop {

    public function Index() {
        $request = request();
        $dbResult = null;
        if ($request->isGet()) {
            $shop = $request->get();
            $map = null;
            $pageSize = $shop['pageSize'];
            $page = $shop['offset'];
            foreach ($shop as $key => $value) {
                if ($key === 'keyword') {
                    $map['goodsname'] = ['like', '%' . $value . '%'];
                } else if ($key === 'goodsclass') {
                    $goodsclass = $shop['goodsclass'];
                    $classarr = explode(',', $goodsclass);
                    $map['goodsclass'] = ['in', $classarr];
                }
            }
            $dbResult = Db::table('sp_goods')->where($map)->page($page, $pageSize)->order('createtime asc')->select();
            if ($dbResult) {
                $resultAll =  Db::table('sp_goods')->where($map)->order('createtime asc')->select();
                $count = count($resultAll);
                $result = ['state' => $this->success(), 'data' => ['goodsList' => $dbResult, 'listSize' => $count]];
            } else {
                $result = ['state' => $this->error()];
            }

            return $result;
        }
    }

    public function success() {
        return ['code' => 200, 'message' => '请求成功'];
    }

    public function error() {
        return ['code' => 500, 'message' => '服务器出错'];
    }

}
