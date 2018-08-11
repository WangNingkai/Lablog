<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Support\Facades\Artisan;
use App\Models\Article;
use App\Models\Message;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Comment;


class DashboardController extends Controller
{
    /**
     * 控制台首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        $articlesCount=Article::query()->count();
        $pagesCount=Page::query()->count();
        $commentsCount=Comment::query()->count();
        $messagesCount = Message::query()->count();
        # 最新未读评论
        $newComments = Comment::query()->where(['status'=>Comment::UNCHECKED])->with('article')->orderBy('created_at', 'desc')->limit(5)->get();
        # 最新未读留言
        $newMessages = Message::query()->where(['status'=>Message::UNCHECKED])->orderBy('created_at', 'desc')->limit(5)->get();
        # 最新发布文章
        $newArticles = Article::query()->orderBy('created_at', 'desc')->limit('6')->get();
        $assign=compact('articlesCount','pagesCount','commentsCount','messagesCount','newArticles','newMessages','newComments');
        return view('admin.index', $assign);
    }

    /**
     * 缓存清理
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clear()
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        show_message('缓存清理成功');
        operation_event(auth()->user()->name,'缓存清理');
        return redirect()->back();
    }
}
