<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/1/30
 * Time: 0:19
 */

namespace app\api\model;

use think\Model;

class Image extends Model
{
    protected $hidden = ['delete_time', 'update_time'];

    //读取器
    public function getUrlAttr($value)
    {
        return config('setting.img_prefix') . $value;
    }

}