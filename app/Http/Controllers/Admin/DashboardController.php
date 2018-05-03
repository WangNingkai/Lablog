<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artisan;
use App\Models\Article;

/* TODO:
 * 权限的使用
 * 用户管理功能
 */

class DashboardController extends Controller
{
    // 控制台首页
    public function home()
    {
        // TODO:前台显示
        // 文章数
        $articleNum = Article::count();
        // 登陆数
        // $loginNum = 0;
        // 评论数
        // $commentNum = 0;
        // 留言数
        // $messageNum = 0;
        // 最新文章
        $newArticles = Article::orderBy('created_at', 'desc')->limit('3')->get();
        // dd(blank($newArticles));
        return view('admin.main.home', compact('articleNum', 'loginNum', 'commentNum', 'messageNum', 'newArticles'));
    }

    /**
     * 缓存清理
     *
     * @return void
     */
    public function clear()
    {
        Artisan::call('cache:clear');
        show_message('缓存清理成功');
        return redirect()->back();
    }
}
