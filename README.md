typecho-muplayer
================

基于百度MuPlayer的Typecho插件

作者：HyanCat

email: <mailto:hyancat@live.cn>

---
muplayer:

version: 0.9.0

[Baidu-Music-Fe-MuPlayer](https://github.com/Baidu-Music-FE/muplayer)

---
插件使用方法：

1. 下载复制至typecho博客程序的plugin目录；
2. 后台启用插件并设置添加歌曲；
3. 在需要展示的页面相应位置调用

 		MuPlayer_Plugin::player();

注：目前仅限定允许在首页调用。后续扩展。