<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/1/31
 * Time: 9:49
 */

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{
    protected $hidden = ['delete_time'];

    //url加前缀
    //public function getUrlAttr($value, $data)
    public function prefixImgUrl($value, $data)
    {
        $finalUrl = $value;
        if ($data['from'] == 1) {
            $finalUrl = config('setting.img_prefix') . $value;
        }
        return $finalUrl;
    }
}