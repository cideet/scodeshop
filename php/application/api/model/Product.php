<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/2
 * Time: 17:10
 */

namespace app\api\model;

class Product extends BaseModel
{
    /**
     * 隐藏单个主题接口不需要输出的字段
     */
    protected $hidden = [
        'delete_time',
        'main_img_id',
        'pivot',  //中间表
        'from',
        'category_id',
        'create_time',
        'update_time'
    ];

    /**
     * 解决图片补全路径的问题
     */
    public function getMainImgUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }

    public function imgs()
    {
        return $this->hasMany('ProductImage', 'product_id', 'id');
    }

    public function properties()
    {
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }

    /**
     * 获取指定数量的最近商品
     */
    public static function getMostRecent($count)
    {
        $products = self::limit($count)->order('create_time desc')->select();
        return $products;
    }

    /**
     * 获取某分类下商品
     * @param $categoryID
     * @param int $page
     * @param int $size
     * @param bool $paginate
     * @return \think\Paginator
     */
    public static function getProductsByCategoryID($categoryId)
    {
        $products = self::where('category_id', '=', $categoryId)->select();
        return $products;
    }

    /**
     * 获取某一个商品
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public static function getProductDetail($id)
    {
        $product = self::with('imgs,properties')->find($id);
        return $product;
        //Query
//        $product = self::with([
//            'imgs' => function($query){
//                $query->with(['imgUrl'])
//                    ->order('order', 'asc');
//            }
//        ])
//            ->with(['properties'])
//            ->find($id);
//        return $product;
    }


}