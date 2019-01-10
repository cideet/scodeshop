<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/9
 * Time: 22:47
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden = ['product_id', 'delete_time', 'id'];
}