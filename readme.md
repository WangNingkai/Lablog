
## 链接
- 博客：[https://imwnk.cn](https://imwnk.cn)
- gitee：[https://github.com/wangningkai/Lablog](https://github.com/wangningkai/Lablog)
- 码云：[https://gitee.com/wangningkai/Lablog](https://gitee.com/wangningkai/Lablog)

## 简介
这个项目是把 [TP5Blog](https://gitee.com/wangningkai/TP5blog) 用 laravel 框架重构后的产物；

## 安装使用

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


## 注意事项

因部分扩展要求需要安装相应php扩展

**FileInfo扩展**
**Imagick扩展**
**GD库扩展** 
**Redis扩展** 

