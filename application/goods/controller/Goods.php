<?php

namespace app\goods\controller;

use think\Request;
use think\Db;

class Goods {

    public function Detail() {
        $request = request();
        if ($request->isGet()) {
            $goodsid = $request->get('goodsId');
            $dbResult = Db::table(['sp_goods'=>'goods','sp_user'=>'user'])->where('goodsid', $goodsid)->where('goods.userid = user.userid')->find();
            if ($dbResult) {
                $salerid = $dbResult['userid'];
                $goodsclass = $dbResult['goodsclass'];
                $authorGoods = Db::table(['sp_goods'=>'goods','sp_user'=>'user'])->where('goods.userid = user.userid')->limit(3)->select();
                $similarGoods = Db::table(['sp_goods'=>'goods','sp_user'=>'user'])->where('goodsclass',$goodsclass)->where('goods.userid = user.userid')->limit(3)->select();
                $result = ['state' => $this->success(), 'data' => ['goodsDetail' => $dbResult, 'authorGoods'=> $authorGoods, 'similarGoods'=>$similarGoods]];
            } else {
                $result = ['state' => $this->error()];
            }
            return $result;
        }
    }

    public function Publish() {
        $request = request();
        if ($request->isPost()) {
            $goods = $request->post();
            $goodsData = [
                'userid' => $goods['userid'],
                'goodsname' => $goods['goodsname'],
                'goodsprice' => $goods['goodsprice'],
                'goodsclass' => $goods['goodsclass'],
                'goodstag' => $goods['goodstag'],
                'goodsintro' => $goods['goodsintro'],
                'goodscover' => $goods['cover'],
                'goodsdetails' => $goods['details'],
            ];
            $dbResult = Db::table('sp_goods')->insert($goodsData);
            if ($dbResult) {
                $result = ['state' => $this->success()];
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
