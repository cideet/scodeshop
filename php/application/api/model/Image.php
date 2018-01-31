<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/1/30
 * Time: 0:19
 */

namespace app\api\model;

class Image extends BaseModel
{
    protected $hidden = ['delete_time', 'update_time'];

    //重写基类prefixUrl方法，使url自动加上前缀
    public function getUrlAttr($value, $data)
    {
        return $this->prefixUrl($value, $data);
    }

}