<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Extensions\Tool;
use App\Models\Subscribe;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubscribeController extends Controller
{
    /**
     * @var Subscribe
     */
    protected $subscribe;

    /**
     * SubscribeController constructor.
     * @param Subscribe $subscribe
     */
    public function __construct(Subscribe $subscribe)
    {
        $this->subscribe = $subscribe;
    }

    /**
     *  订阅列表.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manage(Request $request)
    {
        $keyword = $request->get('keyword') ?? '';
        $map = [];
        $keyword ? array_push($map, ['email', 'like', '%' . $keyword . '%']) : null;
        $subscribes = $this->subscribe->query()->where($map)->orderBy('id', 'desc')->paginate(10);
        return view('admin.subscribe', compact('subscribes'));
    }

    /**
     * 订阅删除.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $data = $request->only('sid');
        $arr = explode(',', $data['sid']);
        $map = [
            'id' => ['in', $arr]
        ];
        $this->subscribe->destroyData($map);
        Tool::recordOperation(auth()->user()->name,'删除订阅');
        return redirect()->back();
    }
}
