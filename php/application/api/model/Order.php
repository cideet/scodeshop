<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2018/2/16
 * Time: 10:30
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['user_id', 'delete_time', 'update_time'];
    protected $autoWriteTimestamp = true;

    //protected $createTime = 'create_timestamp';  //如果自己另外命名的话

    // 读取器：将snap_items从json转成数组
    public function getSnapItemsAttr($value)
    {
        if (empty($value)) {
            return null;
        }
        return json_decode($value);
    }

    public function getSnapAddressAttr($value)
    {
        if (empty($value)) {
            return null;
        }
        return json_decode($value);
    }

    /**
     * 根据用户ID查询其订单（分页）
     * @param $uid
     * @param int $page
     * @param int $size
     * @return \think\Paginator
     */
    public static function getSummaryByUser($uid, $page = 1, $size = 15)
    {
        $pagingData = self::where('user_id', '=', $uid)
            ->order('create_time desc')
            ->paginate($size, true, ['page' => $page]);
        return $pagingData;
    }

    /**
     * 获取全部订单简要信息（分页->管理员）
     * @param int $page
     * @param int $size
     * @return \think\Paginator
     */
    public static function getSummaryByPage($page = 1, $size = 20)
    {
        $pagingData = self::order('create_time desc')
            ->paginate($size, true, ['page' => $page]);
        return $pagingData;
    }

}