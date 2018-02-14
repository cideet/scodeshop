<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/14
 * Time: 19:53
 */

namespace app\api\service;


use app\api\model\Product;

class Order
{
    protected $oProducts;  //订单的商品列表，也就是客户端传递过来的products参数
    protected $products;  //真实的商品信息（包括库存量）
    protected $uid;

    //下单方法
    public function place($uid, $oProducts)
    {
        //对比$oProducts和$products
        $this->oProducts = $oProducts;
        $this->products = $this->getProductSbyOrder($oProducts);
        $this->uid = $uid;
    }

    //根据订单信息查询真实的商品信息
    private function getProductSbyOrder($oProducts)
    {
        //foreach ($oProducts as $oProduct){}  //循环的查询数据库，很不好
        $oPIDs = [];  //订单中所有的商品ID
        foreach ($oProducts as $item) {
            array_push($oPIDs, $item('product_id'));
        }
        $products = Product::all($oPIDs)
            ->visible(['id', 'price', 'stock', 'name', 'main_img_url'])
            ->toArray();
        return $oProducts;
    }

}