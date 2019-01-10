Page({

  onTextTap() {
    console.log('onText');
  },

  onTap: function () {
    // 跳转带返回，最多5级，对应的是onHide
    wx.navigateTo({
      url: "/pages/post/post"
    });

    // 对应的是onUnload
    // wx.redirectTo({
    //   url: "../post/post"
    // });

    // 对应的完整写法
    // wx.navigateTo({
    //   url: '../post/post',
    //   // success: function (res) { console.log('success'); },
    //   // fail: function () { console.log('fail'); },
    //   // complete: function () { console.log('complete'); }
    // });

    // wx.redirectTo({
    //   url: '../post/post',
    //   success: function (res) { console.log('success'); },
    //   fail: function () { console.log('fail'); },
    //   complete: function () { console.log('complete'); }
    // });

  },

  /**
   * 页面的初始数据
   */
  data: {

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    console.log('onLoad');
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
    console.log('onReady');
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    console.log('onShow');
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
    console.log('onHide');
  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {
    console.log('onUnload');
  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {
    console.log('onPullDownRefresh');
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
    console.log('onReachBottom');
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
    console.log('onShareAppMessage');
  }
})