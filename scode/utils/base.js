
import { Config } from '../utils/config.js';

class Base {
    constructor() {
        this.baseRequestUrl = Config.restUrl;
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
                params.sCallback && params.sCallback(res.data);
                // if (params.sCallback) {
                //     params.sCallback(res);
                // }
            },
            fail: function (err) {
                console.log(err);
            }
        })
    }

    //获取元素上绑定的值 data-key
    getDataSet(event, key) {
        return event.currentTarget.dataset[key];
    }
}

export { Base };