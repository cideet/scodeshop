<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/1/30
 * Time: 0:14
 */

namespace app\api\model;

class BannerItem extends BaseModel
{
    protected $hidden = ['delete_time', 'update_time'];
    //protected $visible = ['id'];

    public function img()
    {
        return $this->belongsTo('Image', 'img_id', 'id');  //belongsTo:一对一
        //关联模型的模型名，外键，当前模型的主键
    }
}