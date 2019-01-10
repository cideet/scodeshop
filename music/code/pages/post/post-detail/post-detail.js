var postsData = require('../../../data/posts_data.js');
var app = getApp();  //获取全局变量，就是根目录app.js中的值

Page({

  /**
  * 页面的初始数据
  */
  data: {
    postData: {},
    currentPostid: 0,
    isPlayingMusic: false
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var postid = options.id;
    this.data.currentPostid = postid;
    var postData = postsData.postList[postid];
    this.setData({
      postData: postData
    });
    console.log(this.data.postData);
    // wx.setStorageSync('key11', '张三丰丰');  //设置同步缓存
    // wx.setStorageSync('key11', {  //修改同步缓存
    //   game: '撸呀撸',
    //   developer: '暴雪'
    // });
    var postsCollected = wx.getStorageSync('posts_collected');
    console.log(postsCollected);
    if (postsCollected) {
      var postCollected = postsCollected[postid];
      this.setData({
        collected: postCollected
      });
    } else {
      var postsCollected = {};
      postsCollected[postid] = false;
      wx.setStorageSync('posts_collected', postsCollected);
    }
    if (app.globalData.g_isPlayingMusic && app.globalData.g_currentMusicPostid == postid) {
      this.setData({ isPlayingMusic: true });
    }
    this.setMusicMonitor();  // 同步“页面”和“小程序”的音乐播放器播放状态

  },

  // 同步“页面”和“小程序”的音乐播放器播放状态
  setMusicMonitor: function () {
    var _this = this;
    wx.onBackgroundAudioPlay(function () {
      _this.setData({ isPlayingMusic: true });
      app.globalData.g_isPlayingMusic = true;
      app.globalData.g_currentMusicPostid = _this.data.currentPostid;
    })
    wx.onBackgroundAudioPause(function () {
      _this.setData({ isPlayingMusic: false });
      app.globalData.g_isPlayingMusic = false;
      app.globalData.g_currentMusicPostid = null;
    })
  },

  // 播放或暂停音乐
  onMusicTap: function (event) {
    var currentPostid = this.data.currentPostid;
    var isPlayingMusic = this.data.isPlayingMusic;
    if (isPlayingMusic) {
      wx.pauseBackgroundAudio();
      this.setData({ isPlayingMusic: false });
    } else {
      wx.playBackgroundAudio({
        dataUrl: postsData.postList[currentPostid].music.url,
        title: postsData.postList[currentPostid].music.title,
        coverImgUrl: postsData.postList[currentPostid].music.coverImg
        // dataUrl: "http://ws.stream.qqmusic.qq.com/C100003507bR0gDKBm.m4a?fromtag=38",
        // title: "夜夜夜夜-齐秦",
        // coverImgUrl: "http://y.gtimg.cn/music/photo_new/T002R150x150M000001TEc6V0kjpVC.jpg?max_age=2592000"
      });
      this.setData({ isPlayingMusic: true });
    }
  },

  // 是否收藏
  onColletionTap: function (event) {
    this.getPostsCollectedSyc();  //同步
    // this.getPostsCollectedAsy();  //异步
  },

  // 是否收藏（异步）
  getPostsCollectedAsy: function () {
    var _this = this;
    wx.getStorage({
      key: 'posts_collected',
      success: function (res) {
        var postsCollected = res.data;
        var postCollected = postsCollected[_this.data.currentPostid];
        postCollected = !postCollected;
        postsCollected[_this.data.currentPostid] = postCollected;
        _this.showModel(postsCollected, postCollected);
      },
    })
  },

  // 是否收藏（同步）
  getPostsCollectedSyc: function (event) {
    // var game = wx.getStorageSync('key11');  //获取同步缓存
    // wx.removeStorageSync('key11');  //删除同步缓存
    // wx.clearStorageSync();  //清除所有缓存
    // console.log(game);
    console.log(1);
    var postsCollected = wx.getStorageSync('posts_collected');
    var postCollected = postsCollected[this.data.currentPostid];
    postCollected = !postCollected;
    postsCollected[this.data.currentPostid] = postCollected;
    this.showModel(postsCollected, postCollected);
    // this.showToast(postsCollected, postCollected);
  },

  // model弹出选择框
  showModel: function (postsCollected, postCollected) {
    var _this = this;
    wx.showModal({
      title: '收藏',
      content: postCollected ? '收藏该文章？' : '取消收藏？',
      showCancel: 'true',
      concelText: '取消',
      cancelColor: '#333',
      confirmText: '确定',
      confirmColor: 'red',
      success: function (res) {
        if (res.confirm) {
          wx.setStorageSync('posts_collected', postsCollected);
          _this.setData({
            collected: postCollected
          });
        }
      }
    });
  },

  // 自动消失的提示框
  showToast: function (postsCollected, postCollected) {
    wx.setStorageSync('posts_collected', postsCollected);
    this.setData({
      collected: postCollected
    });
    wx.showToast({
      title: postCollected ? '收藏成功' : '取消成功',
      duration: 1000,
      icon: 'success'  //或loading
    });
  },

  // 分享和下拉选项（出现在底部）
  onShareTap: function (event) {
    var itemList = ['分享给微信好友', '分享到朋友圈', '分享到QQ', '分享到微博'];
    wx.showActionSheet({
      itemList: itemList,
      itemColor: "#405f80",
      success: function (res) {
        // res.cansel  取消
        // res.tapInde  点了第几个确定按钮的索引
        wx.showModal({
          title: '用户分享到了' + itemList[res.tapIndex],
          content: '用户是否取消？' + res.cancel + '现在无法实现分享功能'
        })
      }
    })
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})