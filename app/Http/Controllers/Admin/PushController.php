<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Extensions\Tool;
use App\Http\Requests\Push\Store;
use App\Models\Subscribe;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Push;
use Illuminate\Support\Facades\Log;

class PushController extends Controller
{
    /**
     * @var Push
     */
    protected $push;

    /**
     * PageController constructor.
     * @param Push $push
     */
    public function __construct(Push $push)
    {
        $this->push = $push;
    }

    public function list(Request $request)
    {
        $keyword = $request->get('keyword') ?? '';
        $map = [];
        $keyword ? array_push($map, ['subject', 'like', '%' . $keyword . '%']) : null;
        $pushes =  $this->push
            ->query()
            ->select('id', 'subject','method','status', 'started_at')
            ->where($map)
            ->orderBy('started_at', 'desc')
            ->paginate(10);
        $subscribes = Subscribe::all();
        return view('admin.push', compact('pushes','subscribes'));

    }

    public function info($id = null)
    {
        if (is_null($id)) {
            return abort(404, '对不起，找不到相关页面');
        }
        if (!$response = $this->push->query()->select('subject','target','content')->find($id)->toArray()) {
            return Tool::ajaxReturn(404, ['alert' => '未找到相关数据']);
        }
        return Tool::ajaxReturn(200, $response);
    }


    public function store(Store $request)
    {
        $subject = $request->get('subject');
        $method = $request->get('method');
        $push_time = $request->get('started_at');
        $content = $request->get('content');
        $target_user = $request->get('target');
        $content = Tool::markdown2Html($content);
        $data = [
            'subject' => $subject,
            'method' => $method,
            'started_at' => $method ? $push_time : Carbon::now(),
            'target' => implode('|',$target_user),
            'content' => $content,
            'status'=> $method ? 0 : 1,
        ];
        $this->push->storeData($data);
        $time = 0;
        if ($method) {
            $push_time = strtotime($push_time);
            $time = $push_time - time();
            if ($time < 0) $time = 0;
        }
        // 转换接收的Markdown文本
        Tool::pushSubscribe($subject ,$content,'',$target_user,$time);
        // 记录日志
        Tool::recordOperation(auth()->user()->name,'推送消息');
        Log::info('Send Message To Subscribe',['to' => $target_user ? : 'all', 'message' => $content]);
        Tool::showMessage('推送消息成功');
        return redirect()->back();
    }
}
