// cart-model.js负责与服务器的交互，和修改localStorage

import { Base } from '../../utils/base.js';

class Cart extends Base {
    constructor() {
        super();
        this._storageKeyName = 'cart';
    }

    /**
     * 加入购物车
     * item 商品对象
     * counts 商品数量
     */
    add(item, counts) {
        var cartData = this.getCartDataFromLocal(this._storageKeyName);
        var isHasInfo = this._isHasThatOne(item.id, cartData);
        if (isHasInfo.index == -1) {
            item.counts = counts;
            item.selectStatus = true;  //选中状态
            cartData.push(item);
        } else {
            cartData[isHasInfo.index].counts += counts;
        }
        wx.setStorageSync(this._storageKeyName, cartData);
    }

    /**
     * 从缓存中读取购物车数据
     */
    getCartDataFromLocal(flag) {
        var res = wx.getStorageSync(this._storageKeyName);
        if (!res) {
            res = [];
        }
        //在下单的时候过滤不下单的商品，
        if (flag) {
            var newRes = [];
            for (let i = 0; i < res.length; i++) {
                if (res[i].selectStatus) {
                    newRes.push(res[i]);
                }
            }
            res = newRes;
        }
        return res;
    }

    /**
     * 计算购物车内商品总数量
     * flag=true -> 考虑商品选择状态
     */
    getCartTotalCounts(flag) {
        var data = wx.getStorageSync(this._storageKeyName);
        var counts = 0;
        for (let i = 0; i < data.length; i++) {
            if (flag) {
                if (data[i].selectStatus) {
                    counts += Number(data[i].counts);
                }
            } else {
                counts += data[i].counts;
            }
        }
        return counts;
    }

    //判断某个商品是否已经被添加到购物车中
    _isHasThatOne(id, arr) {
        var item;
        var result = { index: -1 };
        for (let i = 0; i < arr.length; i++) {
            item = arr[i];
            if (item.id == id) {
                result = { index: i, data: item };
                break;
            }
        }
        return result;
    }

    /**
     * 修改商品数目
     * id - {int} 商品id
     * counts -{int} 数目
     * 私有方法，不对外提供接口
     */
    _changeCounts(id, counts) {
        var cartData = this.getCartDataFromLocal(),
            hasInfo = this._isHasThatOne(id, cartData);
        if (hasInfo.index != -1) {
            if (hasInfo.data.counts > 1) {
                cartData[hasInfo.index].counts += counts;
            }
        }
        wx.setStorageSync(this._storageKeyName, cartData);  //更新本地缓存
    };

    //增加商品数目
    addCounts(id) {
        this._changeCounts(id, 1);
    };

    //购物车减
    cutCounts(id) {
        this._changeCounts(id, -1);
    };

    /**
     * 删除商品
     * ids可以是数组
     */
    delete(ids) {
        if (!(ids instanceof Array)) {
            ids = [ids];
        }
        var cartData = this.getCartDataFromLocal();
        for (let i = 0; i < ids.length; i++) {
            var hasInfo = this._isHasThatOne(ids[i], cartData);
            if (hasInfo.index != -1) {
                cartData.splice(hasInfo.index, 1);  //删除数组某一项
            }
        }
        wx.setStorageSync(this._storageKeyName, cartData);
    };

    /*本地缓存 保存／更新*/
    execSetStorageSync(data) {
        wx.setStorageSync(this._storageKeyName, data);
    };

}

export { Cart };