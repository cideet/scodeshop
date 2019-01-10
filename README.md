
##############################################################
# commerce
# https://coding.imooc.com/class/chapter/251.html#Anchor
##############################################################
小程序注册邮件 commerce_minicode@vdouw.com
APPID wxee123885c45afa3c
APPSECRET 5186993798cd389422cb17cff387a038
支付的话，用企业小程序

display:flex;
flex-direction:row; 横向排列
flex-direction:row-reverse; 横向倒序
flex-direction:column; 纵向排列
flex-direction:column-reverse; 纵向倒序



##############################################################
# music
# https://coding.imooc.com/learn/list/75.html
##############################################################

wxa4a0433d833024a3
c30d8c5e4e3df2189ab7c64999f758e7
小程序官方文档 https://mp.weixin.qq.com/debug/wxadoc/dev/
知乎 zhuanlan.zhihu.com/oldtimes
只有text包裹的字体，在手机上才能长按选中
样式用rpx，不要用px
让设计师用750px做设计图

wx.setStorageSync('key11', '张三丰');  //设置同步缓存
wx.setStorageSync('key11', '张四丰');  //修改同步缓存
wx.getStorageSync('key11');  //获取同步缓存
wx.removeStorageSync('key11');  //删除同步缓存
wx.clearStorageSync();  //清除所有缓存

event.target -> 当前点击的组件
event.currentTarget -> 事件捕获的组件

restful API: 豆瓣API 微博API githubAPI 

wx.request({
  url: url,
  method: 'GET', // OPTIONS, GET, HEAD, POST, PUT, DELETE, TRACE, CONNECT
  header: {
    "Content-Type": "application/json11"
  },
  success: function (res) {
    that.processDoubanData(res.data, settedKey, categoryTitle)
  },
  fail: function (error) {
    // fail，比如断网
    console.log(error)
  },
  complete:function(){
    console.log('始终执行');
  }
})




##############################################################
# shop
# https://coding.imooc.com/learn/list/97.html
##############################################################

三端分离 <br>
1、服务端 <br>
    ThinkPHP 5 + MySQL构建REST API <br>
2、客户端 <br>
    向服务端请求数据，完成自身行为逻辑 <br>
3、CMS（数据管理分离） <br>
    向服务端请求数据，实现发货与发送微信消息 <br>

xdebug.org -> download ->

查看端口占用 netstat -ano <br>

豆瓣开放API github开放API <br>

http://127.0.0.3/index.php/sample/test/hello <br>

999  未知错误 <br>
1 开头为通用错误 <br>
2 商品类错误 <br>
3 主题类错误 <br>
4 Banner类错误 <br>
5 类目类错误 <br>
6 用户类错误 <br>
8 订单类错误 <br>

10000 通用参数错误 <br>
10001 资源未找到 <br>
10002 未授权（令牌不合法） <br>
10003 尝试非法操作（自己的令牌操作其他人数据） <br>
10004 授权失败（第三方应用账号登陆失败） <br>
10005 授权失败（服务器缓存异常） <br>
20000 请求商品不存在 <br>
30000 请求主题不存在 <br>
40000 Banner不存在 <br>
50000 类目不存在 <br>
60000 用户不存在 <br>
60001 用户地址不存在 <br>
80000 订单不存在 <br>
80001 订单中的商品不存在，可能已被删除 <br>
80002 订单还未支付，却尝试发货 <br>
80003 订单已支付过111 <br>







