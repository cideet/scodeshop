class Home {
    constructor() { }

    getBannerData(id, callBack) {
        wx.request({
            url: 'http://127.0.0.3/index.php/api/v1/banner/' + id,
            method: 'GET',
            success: function (res) {
                callBack(res);
            }
        })
    }
}

export { Home };