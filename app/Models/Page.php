<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Base
{
    use SoftDeletes;

    # 单页模块 存放关于页面等单一页面。友链页面也可以设置进去

    const STATUS_DISPLAY = 1;
    const STATUS_HIDE = 0;

    /**
     * @return string
     */
    public function getStatusTagAttribute()
    {
        return $this->status === self::STATUS_DISPLAY ? '<a href="javascript:void(0)" class="btn btn-sm btn-success btn-flat">显示</a>' : '<a href="javascript:void(0)" class="btn btn-sm btn-danger btn-flat">隐藏</a>';
    }

    /**
     *
     * @param array $data
     * @return bool|mixed
     */
    public function storeData($data)
    {
        # markdown转html
        unset($data['editormd_id-html-code']);
        $data['html'] = markdown_to_html($data['content']);
        $result = parent::storeData($data);
        baidu_push($result);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
}
