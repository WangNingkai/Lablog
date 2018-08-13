<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Link\Store;
use App\Http\Requests\Link\Update;
use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Helpers\Extensions\Tool;

class LinkController extends Controller
{
    /**
     * @var Link
     */
    protected $link;

    /**
     * LinkController constructor.
     * @param Link $link
     */
    public function __construct(Link $link)
    {
        $this->link = $link;
    }

    /**
     * 友链管理列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manage()
    {
        $links = $this->link->query()->orderBy(DB::raw('sort is null,sort'))->paginate(10);
        return view('admin.link', compact('links'));
    }

    /**
     * 友链存储.
     *
     * @param  \App\Http\Requests\Link\Store $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $this->link->storeData($request->all());
        Tool::recordOperation(auth()->user()->name,'添加标签');
        // 更新缓存
        Cache::forget('cache:link_list');
        return redirect()->back();
    }

    /**
     * 获取友链信息
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id = null)
    {
        if (is_null($id)) {
            return abort(404, '对不起，找不到相关页面');
        }
        if (!$response = $this->link->query()->find($id)) {
            return Tool::ajaxReturn(404, ['alert' => '未找到相关数据']);
        }
        return Tool::ajaxReturn(200, $response);
    }

    /**
     * 友链更新.
     *
     * @param  \App\Http\Requests\Link\Update $request
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request)
    {
        $id = $request->get('id');
        $name=$request->get('edit_name');
        $url=$request->get('edit_url');
        $sort=$request->get('edit_sort');
        $this->link->updateData(['id' => $id], ['name'=>$name,'url'=>$url,'sort'=>$sort,]);
        Tool::recordOperation(auth()->user()->name,'编辑标签');
        // 更新缓存
        Cache::forget('cache:link_list');
        return redirect()->back();
    }

    /**
     * 友链删除.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $data = $request->only('lid');
        $arr = explode(',', $data['lid']);
        $map = [
            'id' => ['in', $arr]
        ];
        $this->link->destroyData($map);
        Tool::recordOperation(auth()->user()->name,'删除标签');
        // 更新缓存
        Cache::forget('cache:link_list');
        return redirect()->back();
    }
}
