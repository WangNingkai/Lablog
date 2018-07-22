<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Link;
use App\Models\Article;
use App\Models\Config;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 分配前台通用的数据
        view()->composer('*', function ($view) {
            $category_list = Cache::remember('app:category_list', 1440, function () {
                // 获取分类导航
                return Category::select('id', 'name')
                    ->where('pid', 0)
                    ->orderBy('sort', 'asc')
                    ->get();
            });
            $tag_list = Cache::remember('app:tag_list', 1440, function () {
                // 获取标签
                return Tag::select('id', 'name')
                    ->orderBy('created_at', 'desc')
                    ->get();
            });
            $link_list = Cache::remember('app:link_list', 1440, function () {
                // 获取友链
                return Link::select('id', 'name', 'url')
                    ->orderBy('sort', 'asc')
                    ->get();
            });
            $top_article_list = Cache::remember('app:top_article_list', 1440, function () {
                // 获取热门文章
                return Article::select('id', 'title')
                    ->orderBy('click', 'desc')
                    ->limit(10)
                    ->get();
            });
            $config = Cache::remember('app:config', 1440, function () {
                // 获取置顶文章
                return Config::pluck('value', 'name');
            });
            // 分配数据
            $assign = compact('category_list', 'tag_list', 'top_article_list', 'link_list','config');
            $view->with($assign);
        });
        // 使用 try catch 是为了解决 composer install 时候触发 php artisan optimize 但此时无数据库的问题
        try {
            // 获取配置项
            $config = Cache::remember('config', 1440, function () {
                return Config::pluck('value','name');
            });
            // 解决初次安装时候没有数据引起报错
            if ($config->isEmpty()) {
                Artisan::call('cache:clear');
            }
        } catch (QueryException $e) {
            // 此处清除缓存是为了解决上面无数据库时缓存时 config 缓存了空数据 db:seed 后 config 走了缓存为空的问题
            Artisan::call('cache:clear');
            $config = [];
        }
        Schema::defaultStringLength(255);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
