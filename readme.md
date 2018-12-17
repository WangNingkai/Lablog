Lablog
============================

### 简介
- 1.博客基于最新 PHP 框架 laravel5 搭建而成；
- 2.前后基于adminlte响应式页面布局，适配PC、平板、手机；
- 3.后台支持QQ、微博、github第三方登录；
- 4.集成优秀的Markdown文本编辑器,支持图片拖拽上传；
- 5.后台基于路由搭建完整的权限控制系统，支持多后台用户。
- 6.后台集成SM.MS上传接口，方便用户上传图片
- 7.后台日志查看

### 链接
- 博客：[https://imwnk.cn](https://imwnk.cn)
- gitee：[https://github.com/wangningkai/Lablog](https://github.com/wangningkai/Lablog)
- 码云：[https://gitee.com/wangningkai/Lablog](https://gitee.com/wangningkai/Lablog)

### 安装使用

```bash
git clone https://gitee.com/wangningkai/Lablog.git tmp 
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

##### 由于部分扩展的要求，需要安装以下php扩展

- `FileInfo`扩展
- `Imagick`扩展
- `GD库`扩展
- `Redis`扩展

##### 可选扩展

- `Beanstalkd` 队列

##### 博客加入push自动更新部署脚本，使用webhooks具体路由

```
http(s)://{host}/hook/(gogs/gitee)
```

##### 自动更新脚本文件

```bash
#!/usr/bin/env bash
PATH=/bin:/sbin:/usr/bin:/usr/sbin:/usr/local/bin:/usr/local/php/bin:/usr/local/sbin:~/bin
export PATH

#=================================================
#       System Required: CentOS
#       Description: Laravel/Lumen Update Shell
#       Author: IMWNK
#       Blog: https://imwnk.cn
#=================================================

action=$1
path=$2

Green_font_prefix="\033[32m" && Red_font_prefix="\033[31m" && Green_background_prefix="\033[42;37m" && Red_background_prefix="\033[41;37m" && Font_color_suffix="\033[0m"
Info="${Green_font_prefix}[Info]${Font_color_suffix}"
Error="${Red_font_prefix}[Error]${Font_color_suffix}"
Tip="${Green_font_prefix}[Tip]${Font_color_suffix}"

if [[ ! -n ${action} ]]; then
        echo -e "${Error} Action Invalid" && exit 1
else
        echo -e "${Info} Your Action Is ${Red_font_prefix}[ ${action} ]${Font_color_suffix}"
fi

if [[ ! -n ${path} ]]; then
        echo -e "${Error} Path Invalid" && exit 1
else
        if [[ ! -d ${path} ]];then
                echo -e "${Error} Path Invalid" && exit 1
        else
                echo -e "${Info} Your Path Is ${Red_font_prefix}[ ${path} ]${Font_color_suffix}"
        fi
fi

cd ${path}
echo -e "${Tip} Start Time ${Green_font_prefix} [`date "+%Y-%m-%d %H:%M:%S"`] ${Font_color_suffix}"
case ${action} in
        pull)
        git fetch --all
        git reset --hard origin/master
        chown -R www:www *
;;
        clear)
        # only for lablog
        /usr/local/php/bin/php artisan flush:cache
        chown -R www:www *
;;
        update)
        git fetch --all
        git reset --hard origin/master
        /usr/local/bin/composer install
        /usr/local/bin/composer update
        chown -R www:www *
;;
esac
echo -e "${Tip} End Time ${Green_font_prefix}[`date "+%Y-%m-%d %H:%M:%S"`]${Font_color_suffix}"

```


第三方配置在`.env`文件配置

[![q.png](https://i.loli.net/2018/08/14/5b72e6d94df76.png)](https://i.loli.net/2018/08/14/5b72e6d94df76.png)

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

