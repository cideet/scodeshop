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
    public function items()
    {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
        //hasMany:1对多
        //关联模型的模型名，外键，当前模型的主键
    }

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