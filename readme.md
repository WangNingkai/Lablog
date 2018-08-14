Lablog
============================

### 简介
- 1.博客基于最新 PHP 框架 laravel5 搭建而成；
- 2.前后基于adminlte响应式页面布局，适配PC、平板、手机；
- 3.后台支持QQ、微博、github第三方登录；
- 4.集成优秀的Markdown文本编辑器Editor.md；
- 5.后台基于路由搭建完整的权限控制系统，支持多后台用户。
- 6.后台集成SM.MS上传接口，方便用户上传图片

### 链接
- 博客：[https://imwnk.cn](https://imwnk.cn)
- gitee：[https://github.com/wangningkai/Lablog](https://github.com/wangningkai/Lablog)
- 码云：[https://gitee.com/wangningkai/Lablog](https://gitee.com/wangningkai/Lablog)

### 安装使用

```bash
git clone -b release https://gitee.com/wangningkai/Lablog.git tmp 
mv tmp/.git . 
rm -rf tmp 
git reset --hard 
composer install -vvv 
php artisan lablog:install
php artisan lablog:migrate 
chmod -R 755 storage/
chown -R www:www *
```

### 注意事项

因部分扩展要求需要安装相应php扩展

**`FileInfo`扩展**
**`Imagick`扩展**
**`GD库`扩展** 
**`Redis`扩展** 

### 分支说明

- release: 测试相对稳定代码

- master: 博客更新维护最新代码

### 版权

项目使用 MIT 协议；免费开源可随意使用；

### 图片演示

#### 前台首页
[![2018-08-09_141946.png](https://i.loli.net/2018/08/09/5b6bdda70fc99.png)](https://i.loli.net/2018/08/09/5b6bdda70fc99.png)

#### 前台首页（手机）
[![2018-08-09_142011.png](https://i.loli.net/2018/08/09/5b6bdda65ce61.png)](https://i.loli.net/2018/08/09/5b6bdda65ce61.png)

#### 登录
[![2018-08-09_142112.png](https://i.loli.net/2018/08/09/5b6bdda5578f6.png)](https://i.loli.net/2018/08/09/5b6bdda5578f6.png)

#### 后台
[![2018-08-09_142051.png](https://i.loli.net/2018/08/09/5b6bdda684bc6.png)](https://i.loli.net/2018/08/09/5b6bdda684bc6.png)

