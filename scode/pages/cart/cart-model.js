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
        if (isHarInfo.index == -1) {
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
    getCartDataFromLocal() {
        var res = wx.getStorageSync(this._storageKeyName);
        if (!res) {
            res = [];
        }
        return res;
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