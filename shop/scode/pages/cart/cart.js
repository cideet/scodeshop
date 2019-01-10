// pages/cart/cart.js

import { Cart } from 'cart-model.js';
var cart = new Cart();

Page({

    /**
     * 页面的初始数据
     */
    data: {

    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {
        // 小程序不关闭，只执行一次
    },

    onHide: function () {
        //解决离开页面时，记录商品的selectStatus值
        // wx.setStorageSync('cart', this.data.cartData);
        cart.execSetStorageSync(this.data.cartData);
    },

    /**
     * 生命周期函数--监听页面显示
     */
    onShow: function () {
        var cartData = cart.getCartDataFromLocal();
        // var countsInfo = cart.getCartTotalCounts(true);
        var cal = this._calcTotalAccountAndCounts(cartData);
        this.setData({
            selectedCounts: cal.selectedCounts,
            selectedTypeCounts: cal.selectedTypeCounts,
            account: cal.account,
            cartData: cartData
        })
    },

    /**
     * 计算订单总金额
     */
    _calcTotalAccountAndCounts: function (data) {
        var len = data.length;
        var account = 0;  //所需要计算的总价格 排除未选中
        var selectedCounts = 0;  //购买商品的总数 排除未选中
        var selectedTypeCounts = 0;  //购买商品种类的总数 排除未选中
        let multiple = 100;
        for (let i = 0; i < len; i++) {
            //避免 0.05 + 0.01 = 0.060 000 000 000 000 005 的问题，乘以 100 *100
            if (data[i].selectStatus) {
                account += data[i].counts * multiple * Number(data[i].price) * multiple;
                selectedCounts += data[i].counts;
                selectedTypeCounts++;
            }
        }
        return {
            selectedCounts: selectedCounts,
            selectedTypeCounts: selectedTypeCounts,
            account: account / (multiple * multiple)
        }
    },

    //单个商品的切换
    toggleSelect: function (event) {
        var id = cart.getDataSet(event, 'id'),
            status = cart.getDataSet(event, 'status'),
            index = this._getProductIndexById(id);
        this.data.cartData[index].selectStatus = !status;
        console.log(this.data.cartData[index].selectStatus);
        this._resetCartData();
    },

    //重新计算总金额和商品总数
    _resetCartData: function () {
        var newData = this._calcTotalAccountAndCounts(this.data.cartData);
        this.setData({
            account: newData.account,
            selectedCounts: newData.selectedCounts,
            selectedTypeCounts: newData.selectedTypeCounts,
            cartData: this.data.cartData
        });
    },

    //是否全选
    toggleSelectAll: function (event) {
        var status = cart.getDataSet(event, 'status') == 'true';
        var data = this.data.cartData,
            len = data.length;
        for (let i = 0; i < len; i++) {
            data[i].selectStatus = !status;
        }
        this._resetCartData();
    },

    //根据商品id得到 商品所在下标
    _getProductIndexById: function (id) {
        var data = this.data.cartData,
            len = data.length;
        for (let i = 0; i < len; i++) {
            if (data[i].id == id) {
                return i;
            }
        }
    },

    //改变数量
    changeCounts: function (event) {
        var id = cart.getDataSet(event, 'id');
        var type = cart.getDataSet(event, 'type');
        var index = this._getProductIndexById(id);
        var counts = 1;
        if (type == 'add') {
            cart.addCounts(id);
        } else {
            counts = -1;
            cart.cutCounts(id);
        }
        this.data.cartData[index].counts += counts;
        this._resetCartData();
    },

    delete: function (event) {
        var id = cart.getDataSet(event, 'id')
        var index = this._getProductIndexById(id);
        this.data.cartData.splice(index, 1);  //删除某一项商品
        this._resetCartData();
        cart.delete(id);  //缓存中删除
    },

    submitOrder: function (event) {
        wx.navigateTo({
            url: '../order/order?account=' + this.data.account + '&from=cart'
        });
    }

})