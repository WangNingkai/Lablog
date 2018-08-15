<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Extensions\Tool;
use App\Models\Comment;
use App\Models\Feed;
use Illuminate\Http\Request;
use App\Http\Requests\Article\Store;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\ArticleTag;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    /**
     * @var Article
     */
    protected $article;

    /**
     * ArticleController constructor.
     * @param Article $article
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * 列举文章列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manage(Request $request)
    {
        $keyword = $request->get('keyword') ?? '';
        $category = $request->get('category') ?? 0 ;
        $map = [];
        $keyword ? array_push($map, ['title', 'like', '%' . $keyword . '%']) : null;
        $category ? array_push($map, ['category_id', '=', $category]) : null;
        $articles =  $this->article
            ->query()
            ->select('id', 'category_id', 'title','status','click', 'created_at')
            ->where($map)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $categories = Tool::getSelect(Category::all()->toArray(),$category);
        return view('admin.article', compact('articles','categories'));
    }

    /**
     * 创建文章
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Tool::getSelect(Category::all()->toArray());
        $tag = Tag::all();
        return view('admin.article-create', compact('category', 'tag'));
    }

    /**
     * 存储文章.
     *
     * @param  \App\Http\Requests\Article\Store $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $id = $this->article->storeData($request->all());
        if ($request->get('status') == $this->article::PUBLISHED) {
            // 推送订阅
            Tool::pushSubscribe('',route('article',$id));
        }
        Tool::recordOperation(auth()->user()->name,'添加文章');
        // 更新缓存
        Cache::forget('cache:top_article_list');
        Cache::forget('feed:articles');
        return redirect()->route('article_manage');
    }

    /**
     * 编辑文章.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = $this->article->query()->find($id);
        $category = Tool::getSelect(Category::all()->toArray(), $article->getAttributeValue('category_id'));
        $tag = Tag::all();
        return view('admin.article-edit', compact('article', 'category', 'tag'));
    }

    /**
     * 更新文章.
     *
     * @param  \App\Http\Requests\Article\Store $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Store $request, $id)
    {
        $data = $request->except('_token');
        $this->article->updateData($id, $data);
        Tool::recordOperation(auth()->user()->name,'编辑文章');
        // 更新缓存
        Cache::forget('cache:top_article_list');
        Cache::forget('feed:articles');
        if (Cache::has('cache:article'.$id)) {
            Cache::forget('cache:article'.$id);
        }
        return redirect()->route('article_manage');
    }

    /**
     * 软删除.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $data = $request->only('aid');
        $arr = explode(',', $data['aid']);
        $map = [
            'id' => ['in', $arr]
        ];
        $this->article->destroyData($map);
        Tool::recordOperation(auth()->user()->name,'软删除文章');
        // 更新缓存
        Cache::forget('cache:top_article_list');
        Cache::forget('feed:articles');
        return redirect()->back();
    }

    /**
     * 显示回收站列表.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $articles = $this->article->query()
        ->select('id', 'title', 'deleted_at')
        ->orderBy('deleted_at', 'desc')
        ->onlyTrashed()
        ->paginate(10);
        return view('admin.article-trash', compact('articles'));
    }

    /**
     * 恢复删除
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function restore(Request $request)
    {
        $data = $request->only('aid');
        $arr = explode(',', $data['aid']);
        if (!$this->article->query()->whereIn('id', $arr)->restore()) {
            Tool::showMessage('恢复失败', false);
            return redirect()->back();
        }
        Tool::showMessage('恢复成功');
        Tool::recordOperation(auth()->user()->name,'恢复软删除文章');
        // 更新缓存
        Cache::forget('cache:top_article_list');
        Cache::forget('feed:articles');
        return redirect()->back();
    }

    /**
     * 彻底删除文章.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request)
    {
        $data = $request->only('aid');
        $arr = explode(',', $data['aid']);
        $deleteOrFail = $this->article->query()->whereIn('id', $arr)->forceDelete();
        if (!$deleteOrFail) {
            // 删除对应标签记录与评论记录
            Tool::showMessage('彻底删除失败', false);
            return redirect()->back();
        } else {
            ArticleTag::query()
                ->whereIn('article_id', $arr)
                ->delete();
            Comment::query()
                ->whereIn('article_id', $arr)
                ->delete();
            Feed::query()
                ->where('target_type',Feed::TYPE_ARTICLE)
                ->whereIn('target_id', $arr)
                ->delete();
        }
        Tool::showMessage('彻底删除成功');
        Tool::recordOperation(auth()->user()->name,'完全删除文章');
        Tool::bdPush($arr,'del');
        // 更新缓存
        Cache::forget('cache:top_article_list');
        Cache::forget('cache:tag_list');
        Cache::forget('feed:articles');
        return redirect()->back();
    }

    public function getByCategory(Request $request)
    {
        $category = $request->get('category');
        $articles = $this->article
            ->query()
            ->select('id', 'category_id', 'title','status','click', 'created_at')
            ->with(['category'=> function ($query) use($category) {
                $query->where('name', $category);
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $categories = Category::query()->select('id','name')->get();
        return view('admin.article', compact('articles','categories'));

    }
}
