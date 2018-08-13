<?php

namespace App\Models;

use App\Helpers\Extensions\Tool;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Base
{
    use SoftDeletes;

    const PUBLISHED   = 1;
    const UNPUBLISHED = 0;
    const ALLOW_COMMENT = 1;
    const FORBID_COMMENT = 0;

    public $tag_ids = [];
    /**
     * 过滤描述中的换行。
     *
     * @param  string  $value
     * @return string
     */
    public function getDescriptionAttribute($value)
    {
        return str_replace(["\r", "\n", "\r\n"], '', $value);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class,'article_tags');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getStatusTagAttribute()
    {
        return $this->attributes['status'] === self::PUBLISHED ? '<a href="javascript:void(0)" class="btn btn-sm btn-success btn-flat">显示</a>' : '<a href="javascript:void(0)" class="btn btn-sm btn-danger btn-flat">隐藏</a>';
    }

    /**
     * 添加文章
     *
     * @param array $data
     * @return bool|mixed
     */
    public function storeData($data)
    {
        // 如果没有描述;则截取文章内容的前200字作为描述
        if (empty($data['description'])) {
            $description = preg_replace(array('/[~*>#-]*/', '/!?\[.*\]\(.*\)/', '/\[.*\]/'), '', $data['content']);
            $data['description'] = re_substr($description, 0, 150, true);
        }

        // markdown转html
        unset($data['editormd_id-html-code']);
        $data['html'] = Tool::markdown2Html($data['content']);
        $tag_ids = $data['tag_ids'];
        unset($data['tag_ids']);
        //添加数据
        $result = parent::storeData($data);
        Tool::bdPush($result);
        if ($result) {
            // 给文章添加标签
            $articleTag = new ArticleTag();
            $articleTag->addTagIds($result, $tag_ids);
            return $result;
        } else {
            return false;
        }
    }

}
