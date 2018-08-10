<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Page\Store;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * @var Page
     */
    protected $page;

    /**
     * PageController constructor.
     * @param Page $page
     */
    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function manage(Request $request)
    {
        $keyword = $request->get('keyword') ?? '';
        $map = [];
        $keyword ? array_push($map, ['title', 'like', '%' . $keyword . '%']) : null;
        $pages =  $this->page
            ->query()
            ->select('id', 'title','status','click', 'created_at')
            ->where($map)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.page', compact('pages'));

    }


    public function create()
    {
        return view('admin.page-create');
    }


    public function store(Store $request)
    {
        $this->page->storeData($request->all());
        operation_event(auth()->user()->name,'添加单页');
        return redirect()->route('page_manage');
    }


    public function edit($id)
    {
        $page = $this->page->query()->find($id);
        return view('admin.page-edit', compact('page'));
    }


    public function update(Store $request, $id)
    {
        $data = $request->except('_token');
        // 把markdown转html
        unset($data['editormd_id-html-code']);
        $data['html'] = markdown_to_html($data['content']);
        // 编辑文章
        $this->page->updateData(['id' => $id], $data);
        operation_event(auth()->user()->name,'编辑单页');
        return redirect()->route('page_manage');
    }


    public function delete(Request $request)
    {
        $data = $request->only('pid');
        $arr = explode(',', $data['pid']);
        $map = [
            'id' => ['in', $arr]
        ];
        $this->page->destroyData($map);
        operation_event(auth()->user()->name,'软删除单页');
        return redirect()->back();
    }


    public function trash()
    {
        $pages = $this->page->query()
            ->select('id', 'title', 'deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->onlyTrashed()
            ->paginate(10);
        return view('admin.page-trash', compact('pages'));
    }


    public function restore(Request $request)
    {
        $data = $request->only('pid');
        $arr = explode(',', $data['pid']);
        if (!$this->page->query()->whereIn('id', $arr)->restore()) {
            show_message('恢复失败', false);
            return redirect()->back();
        }
        show_message('恢复成功');
        operation_event(auth()->user()->name,'恢复软删除单页');
        return redirect()->back();
    }


    public function destroy(Request $request)
    {
        $data = $request->only('pid');
        $arr = explode(',', $data['pid']);
        if (!$this->page->query()->whereIn('id', $arr)->forceDelete()) {
            show_message('彻底删除失败', false);
            return redirect()->back();
        }
        operation_event(auth()->user()->name,'完全删除单页');
        return redirect()->back();
    }
}
