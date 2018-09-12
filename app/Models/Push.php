<?php

namespace App\Models;

class Push extends Base
{
    /**
     * 获取状态标签
     * @return string
     */
    public function getStatusTagAttribute()
    {
        return $this->attributes['status'] === 1 ? '<a href="javascript:void(0)" class="btn btn-sm btn-success btn-flat">已完成</a>' : '<a href="javascript:void(0)" class="btn btn-sm btn-danger btn-flat">未完成</a>';
    }

    /**
     * 获取方式标签
     * @return string
     */
    public function getMethodTagAttribute()
    {
        return $this->attributes['method'] === 0 ? '立即推送' : '定时推送';
    }
}
