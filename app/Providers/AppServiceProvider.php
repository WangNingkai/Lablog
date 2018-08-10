<?php

namespace App\Providers;

use App\Helpers\Extensions\Select;
use App\Models\Nav;
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
            $nav_list = Cache::remember('cache:nav_list', 1440, function () {
                // 获取导航栏
                $data = Nav::query()
                    ->where('status' , Nav::STATUS_DISPLAY)
                    ->orderBy('sort', 'asc')
                    ->get();
                $select =  new Select($data);
                return $result = $select->make_tree();
            });
            $category_list = Cache::remember('cache:category_list', 1440, function () {
                // 获取分类导航
                return Category::query()->select('id', 'name')
                    ->where('parent_id', 0)
                    ->orderBy('sort', 'asc')
                    ->get();
            });

            $tag_list = Cache::remember('cache:tag_list', 1440, function () {
                // 获取标签
                return Tag::query()->select('id', 'name')
                    ->orderBy('created_at', 'desc')
                    ->get();
            });
            $link_list = Cache::remember('cache:link_list', 1440, function () {
                // 获取友链
                return Link::query()->select('id', 'name', 'url')
                    ->orderBy('sort', 'asc')
                    ->get();
            });
            $top_article_list = Cache::remember('cache:top_article_list', 1440, function () {
                // 获取热门文章
                return Article::query()->select('id', 'title')
                    ->orderBy('click', 'desc')
                    ->limit(10)
                    ->get();
            });
            $config = Cache::remember('cache:config', 1440, function () {
                // 获取置顶文章
                return Config::query()->pluck('value', 'name');
            });
            // 分配数据
            $assign = compact('nav_list','category_list', 'tag_list', 'top_article_list', 'link_list','config');
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
