<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artisan;
use App\Models\Article;
use App\Models\Message;


class DashboardController extends Controller
{
    // 控制台首页
    public function home()
    {
        $newMessageCount = Message::where(['status'=>0])->count();

        // 最新文章
        $newArticles = Article::orderBy('created_at', 'desc')->limit('3')->get();
        return view('admin.main.home', compact( 'newArticles','newMessageCount'));
    }

    /**
     * 缓存清理
     *
     * @return void
     */
    public function clear()
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        show_message('缓存清理成功');
        return redirect()->back();
    }
}
