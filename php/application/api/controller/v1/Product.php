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
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ProductException;

class Product
{
    /**
     * 获取指定数量的最近商品
     * @url /product/recent?count=:count
     * @param int $count
     * @return mixed
     * @throws ParameterException
     */
    public function getRecent($count = 15)
    {
        (new Count())->goCheck();
        $products = ProductModel::getMostRecent($count);
        if ($products->isEmpty()) {
            throw new ProductException();
        }
        //$collection = collection($products);  //数据集
        //$products = $collection->hidden(['summary']);
        $products = $products->hidden(['summary']);
        return $products;
    }

    /**
     * 获取某分类下全部商品(不分页）
     * @url /product/all?id=:category_id
     * @param int $id 分类id号
     * @return \think\Paginator
     * @throws ThemeException
     */
    public function getAllInCategory($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $products = ProductModel::getProductsByCategoryID($id);
        if ($products->isEmpty()) {
            throw new ProductException();
        }
        $products = $products->hidden(['summary']);
        return $products;
    }

    /**
     * 商品详情
     * @url /product/:id
     * http://127.0.0.3/index.php/api/v1/product/11
     */
    public function getOne($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $product = ProductModel::getProductDetail($id);
        if (!$product) {
            throw new ProductException();
        }
        return $product;
    }
}