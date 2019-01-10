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
    protected $hidden = ['update_time', 'delete_time', 'id', 'from'];

    //重写基类prefixUrl方法，使url自动加上前缀
    public function getUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }

}