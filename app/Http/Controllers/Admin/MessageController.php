<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Cache;
use Mail;
use App\Mail\SendReply;

class MessageController extends Controller
{
    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * 留言管理列表.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage()
    {
        $messages=$this->message->orderBy('created_at','DESC')->paginate(10);
        return view('admin.message',compact('messages'));
    }

    /**
     * 查看留言.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        if (is_null($id)) {
            return abort(404, '对不起，找不到相关页面');
        }
        if (!$response = $this->message->find($id)) {
            return ajax_return(404, ['alert' => '未找到相关数据']);
        }
        return ajax_return(200, $response);
    }

    /**
     * 审核留言.
     * @param  Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function check(Request $request)
    {
        $data = $request->only('mid');
        $arr = explode(',', $data['mid']);
        $map = [
            'id' => ['in', $arr]
        ];
        $this->message->checkData($map);
        operation_event(auth()->user()->name,'审核留言');
        return redirect()->route('message_manage');
    }

    /**
     * 回复留言.
     *
     * @param  Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function reply(Request $request)
    {
        $this->message->replyData($request->id,$request->reply);
        // 更新缓存
        $emailto=$this->message->where('id',$request->id)->pluck('email');
        operation_event(auth()->user()->name,'回复留言');
        Mail::to( $emailto)->send(new SendReply());
        Cache::forget('app:message_list');
        return redirect()->route('message_manage');
    }

    /**
     * 删除留言.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = $request->only('mid');
        $arr = explode(',', $data['mid']);
        $map = [
            'id' => ['in', $arr]
        ];
        $this->message->destroyData($map);
        operation_event(auth()->user()->name,'删除留言');
        // 更新缓存
        Cache::forget('app:message_list');
        return redirect()->back();
    }
}
