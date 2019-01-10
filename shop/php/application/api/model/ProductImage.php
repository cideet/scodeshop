<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/9
 * Time: 22:44
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['img_id', 'delete_time', 'product_id'];

    public function imgUrl()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}