<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Tag\Store;
use App\Http\Requests\Tag\Update;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\ArticleTag;
use Session;
use Cache;

class TagController extends Controller
{
    protected $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * 标签管理列表.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage()
    {
        $tags = $this->tag->orderBy('id', 'desc')->get();
        foreach ($tags as $tag) {
            $articleCount = ArticleTag::where('tag_id', $tag->id)->count();
            $tag->article_count = $articleCount;
        }
        return view('admin.tag.tag', compact('tags'));
    }

    /**
     * 标签创建存储.
     *
     * @param  \App\Http\Requests\Tag\Store $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $this->tag->storeData($request->all());
        // 更新缓存
        Cache::forget('app:tag_list');
        return redirect()->back();
    }

    /**
     * 标签编辑.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = null)
    {
        if (is_null($id)) {
            abort(404, '对不起，找不到相关页面');
        }
        if (!$response = $this->tag->find($id)) {
            return ajax_return(404, ['alert' => '未找到相关数据']);
        }
        return ajax_return(200, $response);
    }

    /**
     * 标签更新.
     *
     * @param  \App\Http\Requests\Tag\Update $request
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request)
    {
        $id = $request->id;
        $this->tag->updateData(['id' => $id], $request->except('_token'));
        // 更新缓存
        Cache::forget('app:tag_list');
        return redirect()->back();
    }

    /**
     * 标签删除.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = $request->only('tid');
        $arr = explode(',', $data['tid']);
        $map = [
            'id' => ['in', $arr]
        ];
        $this->tag->destroyData($map);
        // 更新缓存
        Cache::forget('app:tag_list');
        return redirect()->back();
    }
}
