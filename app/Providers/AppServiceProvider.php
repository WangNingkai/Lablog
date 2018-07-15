<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Link;
use App\Models\Article;
use App\Models\Message;
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
                    ->limit(8)
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
        Schema::defaultStringLength(191);
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
