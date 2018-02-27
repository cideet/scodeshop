
import { Base } from '../../utils/base.js';

class Home extends Base {
    constructor() {
        super();  //调用基类的构造函数
    }

    getBannerData(id, callBack) {
        var params = {
            url: 'banner/' + id,
            sCallBack: function (res) {
                callBack && callBack(res.items);
            }
        };
        this.request(params);
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