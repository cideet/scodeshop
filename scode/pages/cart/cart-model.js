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
        var cartData = this.getCartDataLocal(this._storageKeyName);
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
    getCartDataLocal() {
        var res = wx.getStorageSync(this._storageKeyName);
        if (!res) {
            res = [];
        }
        return res;
    }

    /**
     * 计算购物车内商品总数量
     */
    getCartTotalCounts() {
        var data = wx.getStorageSync(this._storageKeyName);
        var counts=0;
        for (let i = 0; i < data.length; i++) {
            counts += Number(data[i].counts);
        }
        return counts;
    }

    /**
     * 判断某个商品是否已经被添加到购物车中
     */
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

}

export { Cart };