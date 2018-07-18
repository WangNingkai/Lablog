<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendReply;

class CommentController extends Controller
{
    /**
     * @var Comment
     */
    protected $comment;

    /**
     * CommentController constructor.
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * 留言管理列表.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage()
    {
        $comments=$this->comment->with('article')->orderBy('created_at','DESC')->paginate(10);
//        dd($comments);
        return view('admin.comment',compact('comments'));
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
        if (!$response = $this->comment->find($id)) {
            return ajax_return(404, ['alert' => '未找到相关数据']);
        }
        return ajax_return(200, $response);
    }

    /** 审核回复
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function check(Request $request)
    {
        $data = $request->only('cid');
        $arr = explode(',', $data['cid']);
        $map = [
            'id' => ['in', $arr]
        ];
        $this->comment->checkData($map);
        operation_event(auth()->user()->name,'审核评论');
        return redirect()->route('comment_manage');
    }

    /**
     * 回复留言.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function reply(Request $request)
    {
        $this->comment->replyData($request->id,$request->reply);
        $emailto=$this->comment->where('id',$request->id)->value('email');
        $article_id=$this->comment->where('id',$request->id)->value('article_id');
        operation_event(auth()->user()->name,'回复评论');  //TODO:发邮件
        Mail::to($emailto)->send(new SendReply('站点评论回复提醒','您在我站的评论，站长已经回复，请注意查看.',route('article',$article_id)));
        return redirect()->route('comment_manage');
    }

    /**
     * 删除留言.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = $request->only('cid');
        $arr = explode(',', $data['cid']);
        $map = [
            'id' => ['in', $arr]
        ];
        $this->comment->destroyData($map);
        operation_event(auth()->user()->name,'删除评论');
        return redirect()->back();
    }

}
