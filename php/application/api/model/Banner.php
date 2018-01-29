<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/1/28
 * Time: 20:28
 */

namespace app\api\model;

class Banner
{
    public static function getBannerByID($id)
    {
        $result = \think\Db::query('select * from banner_item where banner_id=?', [$id]);
        return $result;
    }
}