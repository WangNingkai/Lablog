<?php

namespace App\Providers;

use App\Helpers\Extensions\Tool;
use App\Models\Comment;
use App\Models\Message;
use App\Models\Nav;
use App\Models\Page;
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
                    ->where('status', Nav::STATUS_DISPLAY)
                    ->orderBy('sort', 'asc')
                    ->get();
                return Tool::getRecursiveData($data);
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
                    ->orderBy('rank', 'desc')
                    ->limit(10)
                    ->get();
            });
            $config = Cache::remember('cache:config', 1440, function () {
                return Config::query()->pluck('value', 'name');
            });
            $assign = compact('nav_list', 'category_list', 'tag_list', 'top_article_list', 'link_list', 'config');
            $view->with($assign);
        });
        # 获取各种统计
        view()->composer('admin.index', function ($view) {
            $articlesCount = Cache::remember('count:article', 1440, function () {
                // 统计文章总数
                return Article::query()->count('id');
            });

            $commentsCount = Cache::remember('count:comment', 1440, function () {
                // 统计评论总数
                return Comment::query()->count('id');
            });

            $messagesCount = Cache::remember('count:message', 1440, function () {
                // 统计留言总数
                return Message::query()->count('id');
            });

            $pagesCount = Cache::remember('count:page', 1440, function () {
                // 统计单页总数
                return Page::query()->count('id');
            });
            $assign = compact('articlesCount', '', 'commentsCount', 'messagesCount', 'pagesCount');
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
