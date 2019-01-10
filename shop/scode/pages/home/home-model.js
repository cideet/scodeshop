
import { Base } from '../../utils/base.js';

class Home extends Base {
    constructor() {
        super();  //调用基类的构造函数
    }

    //获取banner
    getBannerData(id, callback) {
        var params = {
            url: 'banner/' + id,
            sCallback: function (res) { callback && callback(res.items); }
        };
        this.request(params);
    }

    //首页主题
    getThemeData(callback) {
        var params = {
            url: 'theme?ids=1,2,3',
            sCallback: function (data) { callback && callback(data); }
        };
        this.request(params);
    }

    //获取指定数量的最近商品
    getProductsData(callback) {
        var param = {
            url: 'product/recent',
            sCallback: function (data) { callback && callback(data); }
        };
        this.request(param);
    }

    // getBannerData(id, callBack) {
    //     wx.request({
    //         url: 'http://127.0.0.3/index.php/api/v1/banner/' + id,
    //         method: 'GET',
    //         success: function (res) {
    //             callBack(res);
    //         }
    //     })
    // }
}

export { Home };