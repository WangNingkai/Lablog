<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Extensions\Tool;
use App\Jobs\SendEmail;
use App\Models\Comment;
use Carbon\Carbon;
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
        $categories = get_select(Category::all()->toArray(),$category);
        return view('admin.article', compact('articles','categories'));
    }

    /**
     * 创建文章
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = get_select(Category::all()->toArray());
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
        if($request->get('status') == $this->article::PUBLISHED)
        {
            // 推送订阅
            Tool::pushSubscribe('',route('article',$id));
        }
        operation_event(auth()->user()->name,'添加文章');
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
        $article->tag_ids = ArticleTag::query()->where('article_id', $id)->pluck('tag_id')->toArray();
        $category = get_select(Category::all()->toArray(), $article->category_id);
        $tag = Tag::all();
        return view('admin.article-edit', compact('article', 'category', 'tag'));
    }

    /**
     * 更新文章.
     *
     * @param  \App\Http\Requests\Article\Store $request
     * @param  \App\Models\ArticleTag $articleTagModel
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Store $request, ArticleTag $articleTagModel, $id)
    {
        $data = $request->except('_token');
        // 如果没有描述;则截取文章内容的前150字作为描述
        if (empty($data['description'])) {
            $description = preg_replace(array('/[~*>#-]*/', '/!?\[.*\]\(.*\)/', '/\[.*\]/'), '', $data['content']);
            $data['description'] = re_substr($description, 0, 150, true);
        }
        // 为文章批量添加标签
        $tag_ids = $data['tag_ids'];
        unset($data['tag_ids']);
        // 把markdown转html
        unset($data['editormd_id-html-code']);
        $data['html'] = markdown_to_html($data['content']);
        $articleTagModel->addTagIds($id, $tag_ids);
        // 编辑文章
        $this->article->updateData(['id' => $id], $data);
        operation_event(auth()->user()->name,'编辑文章');
        // 更新缓存
        Cache::forget('cache:top_article_list');
        Cache::forget('feed:articles');
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
        operation_event(auth()->user()->name,'软删除文章');
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
            show_message('恢复失败', false);
            return redirect()->back();
        }
        show_message('恢复成功');
        operation_event(auth()->user()->name,'恢复软删除文章');
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
        if (!$this->article->query()->whereIn('id', $arr)->forceDelete()) {
            show_message('彻底删除失败', false);
            return redirect()->back();
        }
        // 删除对应标签记录与评论记录
        $deleteOrFail = ArticleTag::query()->whereIn('article_id', $arr)->delete() && Comment::query()->whereIn('article_id', $arr)->delete();
        $deleteOrFail ? show_message('彻底删除成功') : show_message('彻底删除失败',false);
        operation_event(auth()->user()->name,'完全删除文章');
        bd_push($arr,'del');

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
