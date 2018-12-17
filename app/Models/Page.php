<?php

namespace App\Models;

use App\Helpers\Extensions\Tool;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Base
{
    use SoftDeletes;

    # 单页模块 存放关于页面等单一页面。友链页面也可以设置进去

    const STATUS_DISPLAY = 1;
    const STATUS_HIDE = 0;

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    public function getFeedAttribute()
    {
        return Feed::query()->where([
            'target_type' => Feed::TYPE_PAGE,
            'target_id'   => $this->attributes['id'],
        ])->first();
    }

    /**
     * @return string
     */
    public function getStatusTagAttribute()
    {
        return $this->attributes['status'] === self::STATUS_DISPLAY
            ? '<a href="javascript:void(0)" class="btn btn-sm btn-success btn-flat">显示</a>'
            : '<a href="javascript:void(0)" class="btn btn-sm btn-danger btn-flat">隐藏</a>';
    }

    /**
     *
     * @param array $data
     *
     * @return bool|mixed
     */
    public function storeData($data)
    {
        $feed['content'] = $data['content'];
        $feed['html'] = Tool::markdown2Html($data['content']);
        unset($data['content']);
        $result = parent::storeData($data);
        if ($result) {
            Feed::query()->create([
                'target_type' => Feed::TYPE_PAGE,
                'target_id'   => $result,
                'content'     => $feed['content'],
                'html'        => $feed['html'],
            ]);

            return $result;
        } else {
            return false;
        }
    }

    /**
     * @param array $id
     * @param array $data
     *
     * @return bool
     */
    public function updateData($id, $data)
    {
        $feed['content'] = $data['content'];
        $feed['html'] = Tool::markdown2Html($data['content']);
        unset($data['content']);
        $result = parent::updateData(['id' => $id], $data);
        if ($result) {
            Feed::query()->where([
                ['target_type', '=', Feed::TYPE_PAGE],
                ['target_id', '=', $id],
            ])->update([
                'content' => $feed['content'],
                'html'    => $feed['html'],
            ]);

            return $result;
        } else {
            return false;
        }
    }
}
