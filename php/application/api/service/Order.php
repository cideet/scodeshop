<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/14
 * Time: 19:53
 */

namespace app\api\service;


use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\model\UserAddress;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;
use think\Exception;

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
        $this->products = $this->getProductsByOrder($oProducts);  //根据订单信息查询真实的商品信息
        $this->uid = $uid;
        $status = $this->getOrderStatus();  //获取订单的真实状态
        if (!$status['pass']) {  //库存量检测未通过
            $status['order_id'] = -1;
            return $status;
        }
        //开始创建订单
        $orderSnap = $this->snapOrder($status);  //生成订单快照
        $order = $this->createOrder($orderSnap);  //生成订单
        $order['pass'] = true;
        return $order;
    }

    //生成订单
    private function createOrder($snap)
    {
        try {
            $orderNo = $this->makeOrderNo();
            $order = new \app\api\model\Order();
            $order->user_id = $this->uid;
            $order->order_no = $orderNo;
            $order->total_price = $snap['orderPrice'];
            $order->total_count = $snap['totalCount'];
            $order->snap_img = $snap['snapImg'];
            $order->snap_name = $snap['snapName'];
            $order->snap_address = $snap['snapAddress'];
            $order->snap_items = json_encode($snap['pStatus']);
            $order->save();  //写入数据表order
            $orderID = $order->id;  //读出订单ID
            $create_time = $order->create_time;
            foreach ($this->oProducts as &$p) {
                $p['order_id'] = $orderID;
            }
            $orderProduct = new OrderProduct();
            $orderProduct->saveAll($this->oProducts);
            return [
                'order_no' => $orderNo,
                'order_id' => $orderID,
                'create_time' => $create_time
            ];
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    //生成订单号
    public static function makeOrderNo()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn =
            $yCode[intval(date('Y')) - 2018] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $orderSn;
    }

    //生成订单快照
    private function snapOrder($status)
    {
        $snap = [
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatus' => [],
            'snapAddress' => null,
            'snapName' => '',
            'snapImg' => ''
        ];
        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArray'];
        $snap['snapAddress'] = json_encode($this->getUserAddress());
        $snap['snapName'] = $this->products[0]['name'];
        $snap['snapImg'] = $this->products[0]['main_img_url'];
        if (count($this->products) > 1) {
            $snap['snapName'] .= '等';
        }
        return $snap;
    }

    private function getUserAddress()
    {
        $userAddress = UserAddress::where('user_id', '=', $this->uid)->find();
        if (!$userAddress) {
            throw new UserException([
                'msg' => '用户收货地址不存在，下单失败',
                'errorCode' => 60001
            ]);
        }
        return $userAddress->toArray();
    }

    //获取订单的真实状态
    private function getOrderStatus()
    {
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatusArray' => []  //订单中所有商品的详细信息
        ];
        foreach ($this->oProducts as $oProduct) {
            $pStatus = $this->getProductStatus($oProduct['product_id'], $oProduct['count'], $this->products);
            if (!$pStatus['haveStock']) {
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['counts'];
            array_push($status['pStatusArray'], $pStatus);
        }
        return $status;
    }

    //订单中某个商品的状态
    private function getProductStatus($oPID, $oCount, $products)
    {
        $pIndex = -1;  //客户端订单的某个商品的ID，在真实订单中的序号
        $pStatus = [  //订单中某一个商品的详细信息
            'id' => null,
            'haveStock' => false,  //是否有库存量
            'counts' => 0,
            'price' => 0,
            'name' => '',
            'totalPrice' => 0,  //单个商品的总价格
            'main_img_url' => null
        ];
        for ($i = 0; $i < count($products); $i++) {
            if ($oPID == $products[$i]['id']) {
                $pIndex = $i;
            }
        }
        if ($pIndex == -1) {
            //客户端传递的productID有可能根本不存在
            throw new OrderException([
                'msg' => 'ID为' . $oPID . '的商品不存在，创建订单失败'
            ]);
        } else {
            $product = $products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['name'] = $product['name'];
            $pStatus['counts'] = $oCount;
            $pStatus['price'] = $product['price'];
            $pStatus['main_img_url'] = $product['main_img_url'];
            $pStatus['totalPrice'] = $product['price'] * $oCount;
            if ($product['stock'] - $oCount >= 0) {
                $pStatus['haveStock'] = true;
            }
        }
        return $pStatus;
    }

    //根据订单信息查询真实的商品信息
    private function getProductsByOrder($oProducts)
    {
        //foreach ($oProducts as $oProduct){}  //循环的查询数据库，很不好
        $oPIDs = [];  //订单中所有的商品ID
        foreach ($oProducts as $item) {
            array_push($oPIDs, $item['product_id']);
        };
        $products = Product::all($oPIDs)->visible(['id', 'price', 'stock', 'name', 'main_img_url'])->toArray();
        return $products;
    }

}