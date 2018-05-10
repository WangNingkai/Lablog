<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Category\Store;
use App\Http\Requests\Category\Update;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Article;
use Session;
use Cache;

class CategoryController extends Controller
{
    protected $category;


    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * 列举文章栏目类别
     *
     * @return \Illuminate\Http\Response
     */
    public function manage()
    {
        // $categories = $this->category->orderBy('sort', 'desc')->get();
        $categories=$this->category->getTreeIndex();
        foreach ($categories as $category) {
            // 文章数量统计
            $articleCount = Article::where('category_id', $category->id)->count();
            $category->article_count = $articleCount;
        }
        return view('admin.category.manage', compact('categories'));
    }

    /**
     * 创建文章栏目.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levelOne = $this->category->select('id', 'name')->where('pid', 0)->get();

        return view('admin.category.create', compact('levelOne'));
    }

    /**
     * 存储文章栏目.
     *
     * @param  \App\Http\Requests\Category\Store $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $this->category->storeData($request->all());
        // 更新缓存
        Cache::forget('app:category_list');
        return redirect()->route('category_manage');
    }

    /**
     * 编辑文章栏目类别.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->category->find($id);
        $map = [
            'pid' => 0,
            'id' => ['<>', $id]
        ];
        $levelOne = $this->category->select('id', 'name')->whereMap($map)->get();
        return view('admin.category.update', compact('category', 'levelOne'));
    }

    /**
     * 更新文章栏目类别.
     *
     * @param  \App\Http\Requests\Category\Update $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $this->category->updateData(['id' => $id], $request->except('_token'));
        // 更新缓存
        Cache::forget('app:category_list');
        return redirect()->route('category_manage');
    }

    /**
     * 删除栏目类别.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = $request->only('cid');
        $arr = explode(',', $data['cid']);
        $map = [
            'id' => ['in', $arr]
        ];
        $this->category->destroyData($map);
        // 更新缓存
        Cache::forget('app:category_list');
        return redirect()->route('category_manage');
    }
}
