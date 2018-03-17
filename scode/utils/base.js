
import { Config } from '../utils/config.js';

class Base {
    constructor() {
        this.baseRequestUrl = Config.restUrl;
    }

    //当noRefech为true时，不做未授权重试机制
    request(params, noRefetch) {
        var url = this.baseRequestUrl + params.url;
        if (!params.type) { params.type = 'GET'; }
        wx.request({
            url: url,
            data: params.data,
            method: params.type,
            header: {
                'content-type': 'application/json',
                'token': wx.getStorageSync('token')
            },
            success: function (res) {
                var code = res.statusCode.toString();
                var startChat = code.charAt(0);
                if (startChat == '2') {  //正常
                    params.sCallback && params.sCallback(res.data);
                } else {
                    if (code == '401') {  //令牌失效
                        // token.getTokenFromServer  //重新获取令牌
                        // base.request
                        if (!noRefetch) {
                            params.eCallback && params.eCallback(res.data);
                        }
                    }
                    params.eCallback && params.eCallback(res.data);
                }
            },
            fail: function (err) {
                console.log(err);
            }
        })
    }

    _refetch(params) {
        var token = new Token();
        token.getTokenFromServer((token) => {
            this.request(params, true);
        });
    }

    //获取元素上绑定的值 data-key
    getDataSet(event, key) {
        return event.currentTarget.dataset[key];
    }
}

export { Base };