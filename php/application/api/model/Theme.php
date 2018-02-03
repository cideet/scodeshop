<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/2
 * Time: 17:11
 */

namespace app\api\model;


class Theme extends BaseModel
{
    protected $hidden = ['head_img_id', 'topic_img_id', 'delete_time', 'update_time'];

    public function topicImg()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');  //一对一
    }

    public function headImg()
    {
        return $this->belongsTo('Image', 'head_img_id', 'id');  //一对一
    }

    /**
     * 查询多个专题
     */
    public function products()
    {
        return $this->belongsToMany('product', 'theme_product', 'product_id', 'theme_id');  //多对多
        //theme_product是中间表
    }

    /**
     * @param $id
     * @return 单个专题
     */
    public static function getThemeWithProducts($id)
    {
        $theme = self::with('products,topicImg,headImg')->find($id);
        return $theme;
    }
}