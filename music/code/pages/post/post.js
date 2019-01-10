var postsData = require('../../data/posts_data.js');  //只能用相对路径

Page({

  onPostTap: function (event) {
    var postid = event.currentTarget.dataset.postid;
    console.log(postid);
    wx.navigateTo({
      url: 'post-detail/post-detail?id=' + postid
    })
  },

  // onSwiperItemTap: function (event) {
  //   var postid = event.currentTarget.dataset.postid;
  //   console.log(postid);
  //   wx.navigateTo({
  //     url: 'post-detail/post-detail?id=' + postid
  //   })
  // },

  onSwiperTap: function (event) {
    var postid = event.target.dataset.postid;
    // event.target -> 当前点击的组件
    // event.currentTarget -> 事件捕获的组件
    console.log(postid);
    wx.navigateTo({
      url: 'post-detail/post-detail?id=' + postid
    });
  },

  /**
   * 页面的初始数据
   */
  data: {
    // 小程序始终会读取data对象，用于数据绑定
    // 在onLoad事件执行之后
    date: "Nov 18 2017"
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    console.log('onLoad');
    this.setData({
      post_content: postsData.postList
    });
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