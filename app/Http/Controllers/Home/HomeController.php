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
use Auth;
use Cache;
use DB;
use Mail;
use App\Mail\SendReminder;


class HomeController extends Controller
{
    public $articleModel;

    public function __construct(Article $articleModel)
    {
        $this->articleModel = $articleModel;
    }

    /**
     * 首页
     */
    public function index()
    {
        $articles = $this->articleModel
            ->select('id', 'category_id', 'title', 'author', 'description','click', 'created_at')
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->with(['category', 'tags'])
            ->simplePaginate(6);
        return view('home.index', compact('articles'));
    }

    /**
     * 文章页
     */
    public function article($id, Request $request)
    {
        $article = $this->articleModel->with(['category', 'tags'])->find($id);
        if(0===$article->status | !is_null($article->deleted_at)){
            return abort(404);
        }
        // 同一个用户访问同一篇文章每天只增加1个访问量  使用 ip+id 作为 key 判别
        $ipAndId = 'articleRequestList' . $request->ip() . ':' . $id;
        if (!Cache::has($ipAndId)) {
            cache([$ipAndId => ''], 1440);
            // 文章点击量+1
            $article->increment('click');
        }
        // 获取上一篇
        $prev = $this->articleModel
            ->select('id', 'title')
            ->orderBy('created_at', 'asc')
            ->where([['id', '>', $id],['status','=',1]])
            ->limit(1)
            ->first();
        // 获取下一篇
        $next = $this->articleModel
            ->select('id', 'title')
            ->orderBy('created_at', 'desc')
            ->where([['id', '<', $id],['status','=',1]])
            ->limit(1)
            ->first();
        // dd($next);
        return view('home.article', compact('article', 'prev', 'next'));
    }

    /**
     * 栏目页
     */
    public function category($id)
    {
        $category = Category::findOrFail($id);
        $childCategoryList=Category::where(['pid'=>$id])->get();
        $articles = $this->articleModel
            ->select('id', 'category_id', 'title', 'author', 'description','click', 'created_at')
            ->where(['status'=>1,'category_id'=>$id])
            ->orderBy('created_at', 'desc')
            ->with(['category', 'tags'])
            ->simplePaginate(10);
        return view('home.category', compact('articles', 'category','childCategoryList'));
    }

    /**
     * 标签页
     */
    public function tag($id)
    {
        $tag = Tag::findOrFail($id);
        $ids = ArticleTag::where('tag_id', $id)->pluck('article_id')->toArray();
        $articles = $this->articleModel
            ->select('id', 'category_id', 'title', 'author', 'description','click', 'created_at')
            ->where('status',1)
            ->whereIn('id', $ids)
            ->orderBy('created_at', 'desc')
            ->with(['category', 'tags'])
            ->simplePaginate(10);
        return view('home.tag', compact('articles', 'tag'));
    }

    /**
     * 归档
     */
    public function archive()
    {

        $archive=$this->articleModel
            ->select(DB::raw('DATE_FORMAT(created_at, \'%Y-%m\') as time, count(*) as posts'))
            ->where('status',1)
            ->groupBy('time')
            ->orderBy('time','desc')
            ->simplePaginate(3);
        foreach ($archive as $v) {
            $start = date('Y-m-d', strtotime($v->time));
            $end = date('Y-m-d', strtotime('+1 Month', strtotime($v->time)));
            $articles = $this->articleModel
                ->select('id', 'title')
                ->where('status', 1)
                ->whereBetween('created_at', [$start, $end])
                ->orderBy('created_at','desc')
                ->get();
            $v->articles = $articles;
        }
        return view('home.archive', compact('archive'));
    }

    /*
     * 留言板
     */
    public function message()
    {
        $messages=Message::where('status',1)->orderBy('created_at', 'desc')->get();
        return view('home.message',compact('messages'));
    }

    public function message_store(Store $request,Message $message)
    {
        $message->storeData($request->all());
        $config=Cache::get('app:config')->toArray();
        Mail::to($config['site_mailto_admin'])->send(new SendReminder());
        // 更新缓存
        Cache::forget('app:message_list');
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
            'title' => ['like', '%' . $keyword . '%'],
            'status' => 1
        ];
        $articles = $this->articleModel
            ->select('id', 'category_id', 'title', 'author', 'description','click', 'created_at')
            ->whereMap($map)
            ->orderBy('created_at', 'desc')
            ->with(['category', 'tags'])
            ->simplePaginate(8);
        $count = $this->articleModel->whereMap($map)->count();
        $articles->count = $count;
        return view('home.search', compact('articles'));
    }
}
