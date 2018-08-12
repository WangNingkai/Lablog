<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Extensions\Tool;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;

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
     * 评论管理列表.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage()
    {
        $comments=$this->comment->with('article')->orderBy('created_at','DESC')->paginate(10);
        return view('admin.comment',compact('comments'));
    }

    /**
     * 查看评论
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        if (is_null($id)) {
            return abort(404, '对不起，找不到相关页面');
        }
        if (!$response = $this->comment->query()->find($id)) {
            return ajax_return(404, ['alert' => '未找到相关数据']);
        }
        return ajax_return(200, $response);
    }

    /** 审核评论
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
     * 回复评论.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function reply(Request $request)
    {
        $id =  $request->get('id');
        $reply = $request->get('reply');
        $this->comment->replyData($id,$reply);
        $emailTo=$this->comment->query()->where('id',$id)->value('email');
        $article_id=$this->comment->query()->where('id',$id)->value('article_id');
        operation_event(auth()->user()->name,'回复评论');
        Tool::pushMessage($emailTo,$emailTo,'您在我站的评论，站长已经回复，请注意查看',route('article',$article_id));
        return redirect()->route('comment_manage');
    }

    /**
     * 删除评论.
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
