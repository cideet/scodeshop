
import { Config } from '../utils/config.js';

class Base {
    constructor() {
        this.baseRequestUrl = 'http://127.0.0.3/index.php/api/v1/';
    }

    request(params) {
        var url = this.baseRequestUrl + params.url;
        if (!params.type) {
            params.type = 'GET';
        }
        wx.request({
            url: url,
            data: params.data,
            method: params.type,
            header: {
                'content-type': 'application/json',
                'token': wx.getStorageSync('token')
            },
            success: function (res) {
                params.sCallBack && params.sCallBack(res.data);
                // if (params.sCallBack) {
                //     params.sCallBack(res);
                // }
            },
            fail: function (err) {
                console.log(err);
            }
        })
    }
}

export { Base };