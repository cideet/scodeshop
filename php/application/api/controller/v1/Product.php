<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/3
 * Time: 17:47
 */

namespace app\api\controller\v1;

use app\api\model\Product as ProductModel;
use app\api\validate\Count;
use app\lib\exception\ProductException;

class Product
{
    public function getRecent($count = 15)
    {
        (new Count())->goCheck();
        $products = ProductModel::getMostRecent($count);
        if ($products->isEmpty()) {
            throw new ProductException();
        }
        $collection = collection($products);  //数据集
        $products = $collection->hidden(['summary']);
        return $products;
    }
}