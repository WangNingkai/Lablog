<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

class Comment extends Base
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * 添加数据
     *
     * @param  array $data 需要添加的数据
     * @return bool        是否成功
     */
    public function storeData($data)
    {
        //添加数据
        $result = $this->create($data);
        if ($result) {
            show_message('评论成功，等待审核');
            return $result->id;
        } else {
            show_message('评论失败',false);
            return false;
        }
    }
    // TODO：单体数据的审核以及多条数据的审核
    /**
     * 审核数据
     *
     * @param array $map
     * @return bool
     */
    public function checkData($map)
    {
        $model = $this
            ->whereMap($map)
            ->get();
        if ($model->isEmpty()) {
            show_message('数据为空，操作失败', false);
            return false;
        }
        foreach ($model as $k => $v) {
            $result = $v->forceFill(['status'=>1])->save();
        }
        if ($result) {
            show_message('操作成功');
            return $result;
        } else {
            show_message('操作失败',false);
            return false;
        }
    }
    /**
     * 回复数据
     *
     * @param  int $id  id
     * @param  mix $reply 回复的数据
     * @return bool        是否成功
     */
    public function replyData($id, $reply)
    {
        $model = $this
            ->find($id);
        // 可能有查不到数据的情况
        if (!$model) {
            show_message('数据为空，回复失败', false);
            return false;
        }
        $result=$model->forceFill(['reply'=>$reply,'status'=>1])->save();
        if ($result) {
            show_message('回复成功');
            return $result;
        } else {
            show_message('回复失败',false);
            return false;
        }
    }
}
