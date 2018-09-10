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

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function push(Request $request)
    {
        $content = $request->get('content');
        $method = $request->get('push_method');
        $push_time = $request->get('push_time');
        $target_user = $request->get('target_user');
        if (blank($content) or !in_array(intval($method),[Subscribe::PUSH_NOW,Subscribe::PUSH_DELAY]) or empty($push_time)) {
            Tool::showMessage('请按要求填写相关内容',false);
            return redirect()->back();
        }
        $time = 0;
        if ($method) {
            if (!$push_time) {
                Tool::showMessage('请按要求填写相关内容',false);
                return redirect()->back();
            }
            $push_time = strtotime($push_time);
            $time = $push_time - time();
        }
        $user_arr = [];
        if ($target_user != 0) {
            $user_arr = explode(',', $target_user);
        }
        // 转换接收的Markdown文本
        $content = Tool::markdown2Html($content);
        Tool::pushSubscribe($content,'',$user_arr,$time);
        // 记录日志
        Log::info('Send Message To Subscribe',['to' => $user_arr ? : 'all', 'message' => $content]);
        Tool::showMessage('推送消息成功');
        return redirect()->back();
    }

    /**
     * 存储推送信息
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        return redirect()->route('subscribe_manage');
    }
}
