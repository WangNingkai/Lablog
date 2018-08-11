<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\SendEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Message;

class MessageController extends Controller
{
    /**
     * @var Message
     */
    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * 留言管理列表.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manage()
    {
        $messages=$this->message->query()->orderBy('created_at','DESC')->paginate(10);
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
        if (!$response = $this->message->query()->find($id)) {
            return ajax_return(404, ['alert' => '未找到相关数据']);
        }
        return ajax_return(200, $response);
    }

    /**
     * 审核留言
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
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
     * 回复留言
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reply(Request $request)
    {
        $id =  $request->get('id');
        $reply = $request->get('reply');
        $this->message->replyData($id,$reply);
        $emailTo=$this->message->query()->where('id',$id)->value('email');
        operation_event(auth()->user()->name,'回复留言');
        $param = [
            'email' => $emailTo,
            'name' => $emailTo,
            'subject' => 'LABLOG 站点留言回复提醒',
            'data' => [
                'name' => $emailTo,
                'content' => '您在我站的留言，站长已经回复，请注意查看。',
                'url' => route('message')
            ],
        ];
        $this->dispatch(new SendEmail($param['email'], $param['name'], $param['subject'], $param['data']));
        return redirect()->route('message_manage');
    }

    /**
     * 删除留言.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
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
        return redirect()->back();
    }
}
