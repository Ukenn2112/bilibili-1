# WordPress博客 B站追番页面


## 将 **anime_bili.php** 文件放到站点根目录

## 效果
![1](https://i.loli.net/2020/03/10/hcei4TDbRp1nCma.png)

## 说明
修改 **bilibili.php** 里面的这串数字，此为本人bilibili uid，应当换成各位同学的uid
<br>
其次打开bilibili，登入后进入个人空间【不要忘记把番剧设置成公开~】
<br>
![1583822762_1_.jpg](https://i.loli.net/2020/03/10/9Efl7u5oa3n6N1i.png)<br><br>
**箭头处即你的UID**<br><br>

打开F12的**Network**并刷新
<br>找到与你UID相同的文件并打开
![ZP_YN223_B1HX_17J__N1D8.png](https://i.loli.net/2020/03/10/WYkMvLwJbcOjla5.png)
<br><br>找到cookie一栏，**完全复制**
此时回到**bilibili.php**，发现你修改的uid后方有预留的格子，里面填入你的cookie保存，并放入你的主题根目录即可
<br><br>
对于图片不显示问题应当在你的主题文件header.php中插入代码
```
<meta name="referrer" content="same-origin">
```
从而解决bilibili防盗链问题<br>
<center>在WP后台新建页面时选择模板，创建页面，即可显示成功。</center>
