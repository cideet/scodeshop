<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/1/28
 * Time: 20:28
 */

namespace app\api\model;

use think\Model;

class Banner extends Model
{
    public static function getBannerByID($id)
    {
        // find select update insert delete
        // where('字段名','表达式','查询条件');

//        $result = \think\Db::query('select * from banner_item where banner_id=?', [$id]);  //原生SQL语句
//        return json($result);

        $result = \think\Db::table('banner_item')->where('banner_id', '=', $id)->find();  //查询构造器
        return $result;
    }
}