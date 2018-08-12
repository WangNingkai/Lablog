<?php

namespace App\Http\Controllers\Home;

use App\Helpers\Extensions\Tool;
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
use App\Models\Config;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    const CACHE_EXPIRE = 1440;

    public $config;

    public function __construct()
    {
        $this->config = Cache::remember('cache:config', self::CACHE_EXPIRE, function () {
            // 获取置顶文章
            return Config::query()->pluck('value', 'name');
        });
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $articles = Article::query()->select('id', 'category_id', 'title', 'author', 'description','click', 'created_at')
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->with(['category', 'tags','comments'=>function ($query) {
                $query->where('status', Article::PUBLISHED);
            }])
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
        $article = Article::with(['category', 'tags','comments'=>function ($query) {
            $query->where('status', Article::PUBLISHED);
        }])->whereId($id)->first();
        if( is_null($article) || 0 === $article->status || !is_null($article->deleted_at) ){
            return abort(404);
        }
        $key = 'articleRequestList:'.$id.':'.$request->ip();
        if (!Cache::has($key)) {
            Cache::put($key,$request->ip(), 1440);
            $article->increment('click');
        }
        // 获取上一篇
        $prev = Article::query()->select('id', 'title')
            ->orderBy('created_at', 'asc')
            ->where([['id', '>', $id],['status','=',Article::PUBLISHED]])
            ->limit(1)
            ->first();

        // 获取下一篇
        $next = Article::query()->select('id', 'title')
            ->orderBy('created_at', 'desc')
            ->where([['id', '<', $id],['status','=',Article::PUBLISHED]])
            ->limit(1)
            ->first();
        return view('home.article', compact('article', 'prev', 'next'));
    }

    public function page($id)
    {
        $page = Page::query()->where('id',$id)->first();
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
        Tool::pushMessage($this->config['site_mailto_admin'],'站长大大','您的博客现有新的评论，请注意查看审核',route('comment_manage'));
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

        $articles = Article::query()->select('id', 'category_id', 'title', 'author', 'description','click', 'created_at')
            ->where(['status'=>Article::PUBLISHED,'category_id'=>$id])
            ->orderBy('created_at', 'desc')
            ->with(['category', 'tags', 'comments'=>function ($query) {
                $query->where('status', Article::PUBLISHED);
            }])
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

        $articles = Article::query()->select('id', 'category_id', 'title', 'author', 'description','click', 'created_at')
            ->where('status',Article::PUBLISHED)
            ->whereIn('id', $ids)
            ->orderBy('created_at', 'desc')
            ->with(['category', 'tags', 'comments'=>function ($query) {
                $query->where('status', Comment::CHECKED);
            }])
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
        $messages = Message::query()->where('status',Message::CHECKED)->orderBy('created_at', 'desc')->get();
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
        Tool::pushMessage($this->config['site_mailto_admin'],'站长大大','您的博客现有新的留言，请注意查看审核',route('comment_manage'));
        return redirect()->back();
    }

    public function subscribe()
    {
        return view('home.subscribe');
    }



    public function subscribe_store(SubscribeStore $request, Subscribe $subscribe)
    {
        $data = $request->all();
        $data['ip'] = $request->ip();
        $subscribe->storeData($data);
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
        $articles = Article::query()->select('id', 'category_id', 'title', 'author', 'description','click', 'created_at')
            ->where($map)
            ->orderBy('created_at', 'desc')
            ->with(['category', 'tags'])
            ->simplePaginate(8);
        $count = Article::query()->where($map)->count();
        $articles->count = $count;
        return view('home.search', compact('articles'));
    }

    /**
     * 引入feed
     *
     * @return \Illuminate\Support\Facades\View
     */
    public function feed()
    {
        $articles = Cache::remember('feed:articles', self::CACHE_EXPIRE, function () {
            return Article::query()->select('id', 'author', 'title', 'description', 'html', 'created_at')
                ->latest()
                ->get();
        });
        $feed = App::make("feed");
        $feed->title = $this->config['site_title'];
        $feed->description = $this->config['site_description'];
        $feed->logo = 'https://share.imwnk.cn/Images/favicon.ico';
        $feed->link = url('feed');
        $feed->setDateFormat('carbon');
        $feed->pubdate = $articles->first()->created_at;
        $feed->lang = 'zh-CN';
        $feed->ctype = 'application/xml';

        foreach ($articles as $article)
        {
            $feed->add($article->title, $article->author, url('article', $article->id), $article->created_at, $article->description);
        }
        return $feed->render('atom');
    }
}
