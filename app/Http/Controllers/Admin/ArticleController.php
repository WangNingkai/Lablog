<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Article\Store;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\ArticleTag;
use Cache;

class ArticleController extends Controller
{

    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * 列举文章列表
     *
     * @return \Illuminate\Http\Response
     */
    public function manage()
    {
        $articles = $this->article->getAdminList();
        return view('admin.article.manage', compact('articles'));
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
        return view('admin.article.create', compact('category', 'tag'));
    }

    /**
     * 存储文章.
     *
     * @param  \App\Http\Requests\Article\Store $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $this->article->storeData($request->all());
        // 更新缓存
        Cache::forget('app:article_list');
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
        $article = $this->article->find($id);
        $article->tag_ids = ArticleTag::where('article_id', $id)->pluck('tag_id')->toArray();
        $category_all = Category::all();
        $category = get_select($category_all->toArray(), $article->category_id);
        $tag = Tag::all();
        return view('admin.article.update', compact('article', 'category', 'tag'));
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
        // 为文章批量添加标签
        $tag_ids = $data['tag_ids'];
        unset($data['tag_ids']);
        // 把markdown转html
        unset($data['editormd_id-html-code']);
        $data['html'] = markdown_to_html($data['content']);
        $articleTagModel->addTagIds($id, $tag_ids);
        // 编辑文章
        $this->article->updateData(['id' => $id], $data);
        // 更新缓存
        Cache::forget('app:article_list');
        return redirect()->back();
    }

    /**
     * 软删除.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = $request->only('aid');
        $arr = explode(',', $data['aid']);
        $map = [
            'id' => ['in', $arr]
        ];
        $this->article->destroyData($map);
        // 更新缓存
        Cache::forget('app:article_list');
        return redirect()->back();
    }

    /**
     * 显示回收站列表.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $articles = $this->article->onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('admin.article.trash', compact('articles'));
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
        if (!$this->article->whereIn('id', $arr)->restore()) {
            show_message('恢复失败', false);
            return redirect()->back();
        }
        show_message('恢复成功');
        // 更新缓存
        Cache::forget('app:article_list');
        return redirect()->back();
    }

    /**
     * 彻底删除文章.
     *
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function forceDelete(Request $request)
    {
        $data = $request->only('aid');
        $arr = explode(',', $data['aid']);
        if (!$this->article->whereIn('id', $arr)->forceDelete()) {
            show_message('彻底删除失败', false);
            return redirect()->back();
        }
        // 删除对应标签记录
        $articleTagModel = new ArticleTag;
        $articleTagModel->whereIn('article_id', $arr)->forceDelete();
        show_message('彻底删除成功');
        // 更新缓存
        Cache::forget('app:tag_list');
        return redirect()->back();
    }
}
