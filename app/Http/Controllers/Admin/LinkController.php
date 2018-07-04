<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Link\Store;
use App\Http\Requests\Link\Update;
use App\Http\Controllers\Controller;
use App\Models\Link;
use Session;
use DB;
use Cache;

class LinkController extends Controller
{
    protected $link;


    public function __construct(Link $link)
    {
        $this->link = $link;
    }

    /**
     * 友链管理列表.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage()
    {
        $links = $this->link->orderBy(DB::raw('sort is null,sort'))->get();
        return view('admin.link.link', compact('links'));
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
        operation_event(auth()->user()->name,'添加标签');
        // 更新缓存
        Cache::forget('app:link_list');
        return redirect()->back();
    }

    /**
     * 友链编辑.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = null)
    {
        if (is_null($id)) {
            return abort(404, '对不起，找不到相关页面');
        }
        if (!$response = $this->link->find($id)) {
            return ajax_return(404, ['alert' => '未找到相关数据']);
        }
        return ajax_return(200, $response);
    }

    /**
     * 友链更新.
     *
     * @param  \App\Http\Requests\Link\Update $request
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request)
    {
        $id = $request->id;
        $result = $this->link->updateData(['id' => $id], $request->except('_token'));
        operation_event(auth()->user()->name,'编辑标签');
        // 更新缓存
        Cache::forget('app:link_list');
        return redirect()->back();
    }

    /**
     * 友链删除.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = $request->only('lid');
        $arr = explode(',', $data['lid']);
        $map = [
            'id' => ['in', $arr]
        ];
        $this->link->destroyData($map);
        operation_event(auth()->user()->name,'删除标签');
        // 更新缓存
        Cache::forget('app:link_list');
        return redirect()->back();
    }
}
