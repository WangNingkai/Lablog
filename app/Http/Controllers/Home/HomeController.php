<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Requests\Message\Store;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Link;
use App\Models\Message;
use App\Mail\SendReminder;
use Auth;
use Cache;
use DB;
use Mail;
use App;
use App\Events\ArticleViewEvent;



class HomeController extends Controller
{
    const CACHE_EXPIRE = 43200;

    public $config;

    public function __construct()
    {
        $this->config = Cache::get('app:config')->toArray();
    }

    /**
     * 首页
     */
    public function index()
    {
        $articles = Cache::remember('articles:list', self::CACHE_EXPIRE, function () {
            return Article::select('id', 'category_id', 'title', 'author', 'description','click', 'created_at')
                        ->where('status', 1)
                        ->orderBy('created_at', 'desc')
                        ->with(['category', 'tags'])
                        ->simplePaginate(6);
        });
        return view('home.index', compact('articles'));
    }

    /**
     * 文章页
     */
    public function article($id, Request $request)
    {
        //Redis缓存中没有该article,则从数据库中取值,并存入Redis中,该键值key='article:cache'.$id生命时间5分钟
        $article = Cache::remember('article:'.$id, self::CACHE_EXPIRE, function () use ($id) {
            return Article::with(['category', 'tags'])->whereId($id)->first();
        });

        if( 0 === $article->status | !is_null($article->deleted_at) ){
            return abort(404);
        }
        //获取客户端请求的IP
        $ip = $request->ip();
        //触发浏览次数统计时间
        event(new ArticleViewEvent($article, $ip));

        // 获取上一篇
        $prev = Cache::remember('article:'.$id.':pre', self::CACHE_EXPIRE, function () use ($id) {
            return Article::select('id', 'title')
                        ->orderBy('created_at', 'asc')
                        ->where([['id', '>', $id],['status','=',1]])
                        ->limit(1)
                        ->first();
        });

        // 获取下一篇
        $next = Cache::remember('article:'.$id.':next', self::CACHE_EXPIRE, function () use ($id) {
            return Article::select('id', 'title')
                        ->orderBy('created_at', 'desc')
                        ->where([['id', '<', $id],['status','=',1]])
                        ->limit(1)
                        ->first();
        });
        return view('home.article', compact('article', 'prev', 'next'));
    }

    /**
     * 栏目页
     */
    public function category($id)
    {
        $category = Category::findOrFail($id);
        $childCategoryList=Category::where(['pid'=>$id])->get();

        $articles = Cache::remember('category:'.$id.':articles:list', self::CACHE_EXPIRE, function () use ($id) {
            return Article::select('id', 'category_id', 'title', 'author', 'description','click', 'created_at')
                        ->where(['status'=>1,'category_id'=>$id])
                        ->orderBy('created_at', 'desc')
                        ->with(['category', 'tags'])
                        ->simplePaginate(10);
        });
        return view('home.category', compact('articles', 'category','childCategoryList'));
    }

    /**
     * 标签页
     */
    public function tag($id)
    {
        $tag = Tag::findOrFail($id);
        $ids = ArticleTag::where('tag_id', $id)->pluck('article_id')->toArray();

        $articles = Cache::remember('tag:'.$id.':articles:list', self::CACHE_EXPIRE, function () use ($ids) {
            return Article::select('id', 'category_id', 'title', 'author', 'description','click', 'created_at')
                        ->where('status',1)
                        ->whereIn('id', $ids)
                        ->orderBy('created_at', 'desc')
                        ->with(['category', 'tags'])
                        ->simplePaginate(10);
        });
        return view('home.tag', compact('articles', 'tag'));
    }

    /**
     * 归档
     */
    public function archive()
    {
        if( !Cache::has('archive:list') )
        {
            $archive = Article::select(DB::raw('DATE_FORMAT(created_at, \'%Y-%m\') as time, count(*) as posts'))
                            ->where('status',1)
                            ->groupBy('time')
                            ->orderBy('time','desc')
                            ->simplePaginate(3);
            foreach ($archive as $v) {
                $start = date('Y-m-d', strtotime($v->time));
                $end = date('Y-m-d', strtotime('+1 Month', strtotime($v->time)));
                $articles = Article::select('id', 'title')
                                ->where('status', 1)
                                ->whereBetween('created_at', [$start, $end])
                                ->orderBy('created_at','desc')
                                ->get();
                $v->articles = $articles;
            }
            Cache::put('archive:list', $archive, self::CACHE_EXPIRE);
        }
        $archive = Cache::get('archive:list');
        return view('home.archive', compact('archive'));
    }

    /*
     * 留言板
     */
    public function message()
    {
        $messages = Cache::remember('messages:list', self::CACHE_EXPIRE, function () use ($ids) {
            return Message::where('status',1)->orderBy('created_at', 'desc')->get();
        });
        return view('home.message',compact('messages'));
    }

    // 留言
    public function message_store(Store $request,Message $message)
    {
        $message->storeData($request->all());
        Mail::to($this->config['site_mailto_admin'])->send(new SendReminder());
        return redirect()->route('message');

    }

    /**
     * 关于页
     */
    public function about()
    {
        return view('home.about');
    }

    /**
     * 搜索
     */
    public function search()
    {
        $keyword = request()->input('keyword');
        $map = [
            ['title', 'like', '%' . $keyword . '%'],
            ['status', '=', 1]
        ];
        $articles = Article::select('id', 'category_id', 'title', 'author', 'description','click', 'created_at')
            ->where($map)
            ->orderBy('created_at', 'desc')
            ->with(['category', 'tags'])
            ->simplePaginate(8);
        $count = Article::where($map)->count();
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
        $articles = Cache::remember('feed:article', self::CACHE_EXPIRE, function () {
            return Article::select('id', 'author', 'title', 'description', 'html', 'created_at')
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
