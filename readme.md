Lablog
============================

### 简介
- 1.博客基于最新 PHP 框架 laravel5 搭建而成；
- 2.前台响应式页面布局适配PC、平板、手机；
- 3.后台支持QQ、微博、github第三方登录；
- 4.集成优秀的Markdown文本编辑器Editor.md；
- 5.后台基于路由搭建完整的权限控制系统，支持多后台用户。

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
cp .env.example .env 
composer install -vvv 
php artisan key:generate
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
