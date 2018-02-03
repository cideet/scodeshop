<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/1/28
 * Time: 18:34
 */

namespace app\api\controller\v1;

use app\api\model\Banner as BannerModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\BannerMissException;
use think\Exception;

class Banner
{
    /**
     * 获取指定ID的banner信息
     * @url /banner/:id
     * @http GET
     * @id banner ID号
     */
    public function getBanner($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        //$banner = new BannerModel();  //实例化后，对应表banner了
        //$banner = $banner->get($id);
//        $banner = BannerModel::get($id);  //建议使用静态方法
        //$banner = BannerModel::getBannerByID($id);  //作用同上

        //$banner = BannerModel::with('items')->find($id);
//        $banner = BannerModel::with(['items', 'items.img'])->find($id);
        $banner = BannerModel::getBannerByID($id);
        //$banner->hidden(['update_time','delete_time']);  //隐藏某些字段
        //$banner->visible(['id']);  //只显示某些字段
        if (!$banner) {
            throw new BannerMissException();
        }
        return $banner;
    }
}