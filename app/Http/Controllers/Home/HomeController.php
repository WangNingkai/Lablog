<?php

namespace App\Http\Controllers\Home;

use App\Helpers\Extensions\Tool;
use App\Models\Config;
use App\Models\Page;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use App\Http\Requests\Message\Store as MessageStore;
use App\Http\Requests\Comment\Store as CommentStore;
use App\Http\Requests\Subscribe\Store as SubscribeStore;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Article;
use App\Models\Comment;
use App\Models\ArticleTag;
use App\Models\Message;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    const CACHE_EXPIRE = 1440;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $articles = Article::query()->select('id', 'category_id', 'title', 'author', 'description','click')
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->with(['category', 'tags'])
            ->simplePaginate(6);
        return view('home.index', compact('articles'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function article($id, Request $request)
    {
        $article = Cache::remember('cache:article'.$id, self::CACHE_EXPIRE, function () use ($id) {
            return Article::query()->with(['category', 'tags','comments' => function ($query) {
                $query->where('status', Comment::CHECKED);
            }])->where('id',$id)->first();
        });
        if ( is_null($article) || 0 === $article->status || !is_null($article->deleted_at) ) {
            return abort(404);
        }
        $key = 'articleRequestList:'.$id.':'.$request->ip();
        if (!Cache::has($key)) {
            Cache::put($key,$request->ip(), 60);
            $article->increment('click');
        }
        $prev = Cache::remember('cache:article'.$id.':prev', self::CACHE_EXPIRE, function () use ($id){
            return Article::query()->select('id', 'title')
                ->orderBy('created_at', 'asc')
                ->where([['id', '>', $id],['status','=',Article::PUBLISHED]])
                ->limit(1)
                ->first();
        });

        $next = Cache::remember('cache:article'.$id.':next', self::CACHE_EXPIRE, function () use ($id){
            return Article::query()->select('id', 'title')
                ->orderBy('created_at', 'desc')
                ->where([['id', '<', $id],['status','=',Article::PUBLISHED]])
                ->limit(1)
                ->first();
        });

        return view('home.article', compact('article', 'prev', 'next'));
    }

    public function page($id, Request $request)
    {
        $page = Cache::remember('cache:page'.$id, self::CACHE_EXPIRE, function () use ($id) {
            return Page::query()->where('id',$id)->first();
        });
        $key = 'pageRequestList:'.$id.':'.$request->ip();
        if (!Cache::has($key)) {
            Cache::put($key,$request->ip(), 60);
            $page->increment('click');
        }
        return view('home.page',compact('page'));
    }

    /**
     * @param CommentStore $request
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function comment_store(CommentStore $request,Comment $comment)
    {
        $data = $request->all();
        $data['ip'] = request()->ip();
        $comment->storeData($data);
        Tool::pushMessage(Tool::config('site_mailto_admin'),'站长大大','您的博客现有新的评论，请注意查看审核',route('comment_manage'));
        return redirect()->back();

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category($id)
    {
        $category = Category::query()->findOrFail($id);
        $childCategoryList=Category::query()->where(['parent_id'=>$id])->get();
        $articles = Article::query()->select('id', 'category_id', 'title', 'author', 'description','click')
            ->where(['status' => Article::PUBLISHED,'category_id' => $id])
            ->orderBy('created_at', 'desc')
            ->with(['category', 'tags'])
            ->simplePaginate(10);
        return view('home.category', compact('articles', 'category','childCategoryList'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tag($id)
    {
        $tag = Tag::query()->findOrFail($id);
        $ids = ArticleTag::query()->where('tag_id', $id)->pluck('article_id')->toArray();

        $articles = Article::query()->select('id', 'category_id', 'title', 'author', 'description','click')
            ->where('status',Article::PUBLISHED)
            ->whereIn('id', $ids)
            ->orderBy('created_at', 'desc')
            ->with(['category', 'tags'])
            ->simplePaginate(10);
        return view('home.tag', compact('articles', 'tag'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function archive()
    {
        $archive = Article::query()->select(DB::raw('DATE_FORMAT(created_at, \'%Y-%m\') as time, count(*) as posts'))
            ->where('status',Article::PUBLISHED)
            ->groupBy('time')
            ->orderBy('time','desc')
            ->simplePaginate(3);
        foreach ($archive as $v) {
            $start = date('Y-m-d', strtotime($v->time));
            $end = date('Y-m-d', strtotime('+1 Month', strtotime($v->time)));
            $articles = Article::query()->select('id', 'title')
                ->where('status', Article::PUBLISHED)
                ->whereBetween('created_at', [$start, $end])
                ->orderBy('created_at','desc')
                ->get();
            $v->articles = $articles;
        }
        return view('home.archive', compact('archive'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function message()
    {
        $messages = Message::query()
            ->where('status',Message::CHECKED)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('home.message',compact('messages'));
    }

    /**
     * @param MessageStore $request
     * @param Message $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function message_store(MessageStore $request,Message $message)
    {
        $data = $request->all();
        $data['ip'] = request()->ip();
        $message->storeData($data);
        Tool::pushMessage(Tool::config('site_mailto_admin'),'站长大大','您的博客现有新的留言，请注意查看审核',route('message_manage'));
        return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function subscribe()
    {
        return view('home.subscribe');
    }

    /**
     * @param SubscribeStore $request
     * @param Subscribe $subscribe
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subscribe_store(SubscribeStore $request, Subscribe $subscribe)
    {
        $data = $request->all();
        $data['ip'] = $request->ip();
        $subscribe->storeData($data);
        Tool::showMessage('订阅成功');
        return redirect()->route('home');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search()
    {
        $keyword = request()->input('keyword');
        $map = [
            ['title', 'like', '%' . $keyword . '%'],
            ['status', '=', Article::PUBLISHED]
        ];
        $articles = Article::query()->select('id', 'category_id', 'title', 'author', 'description','click')
            ->where($map)
            ->orderBy('created_at', 'desc')
            ->with(['category', 'tags'])
            ->simplePaginate(8);
        $count = Article::query()->where($map)->count();
        $articles->count = $count;
        return view('home.search', compact('articles'));
    }
}
