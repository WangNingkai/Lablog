<?php

namespace App\Models;

use App\Helpers\Extensions\Tool;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Base
{
    use SoftDeletes;

    const PUBLISHED = 1;
    const UNPUBLISHED = 0;
    const ALLOW_COMMENT = 1;
    const FORBID_COMMENT = 0;

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
        return $this->belongsToMany(Tag::class, 'article_tags');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    public function getFeedAttribute()
    {
        return Feed::query()->where([
            'target_type' => Feed::TYPE_ARTICLE,
            'target_id' => $this->attributes['id'],
        ])->first();
    }

    /**
     * @return array
     */
    public function getTagIdsAttribute()
    {
        return ArticleTag::query()->where('article_id', $this->attributes['id'])->pluck('tag_id')->toArray();
    }

    /**
     * @return int
     */
    public function getCommentCountAttribute()
    {
        return Comment::query()->where(['article_id' => $this->attributes['id'], 'status' => Comment::CHECKED])->count();
    }

    /**
     * @return mixed
     */
    public function getFeedUpdatedAtAttribute()
    {
        return Feed::query()->where(['target_type' => Feed::TYPE_ARTICLE, 'target_id' => $this->attributes['id']])->value('updated_at');
    }

    /**
     * 获取状态标签
     * @return string
     */
    public function getStatusTagAttribute()
    {
        return $this->attributes['status'] === self::PUBLISHED ? '<a href="javascript:void(0)" class="btn btn-sm btn-success btn-flat">显示</a>' : '<a href="javascript:void(0)" class="btn btn-sm btn-danger btn-flat">隐藏</a>';
    }

    /**
     * 过滤描述中的换行。
     *
     * @param  string $value
     * @return string
     */
    public function getDescriptionAttribute($value)
    {
        return str_replace(["\r", "\n", "\r\n"], '', $value);
    }

    /**
     * 添加文章
     *
     * @param array $data
     * @return bool|mixed
     */
    public function storeData($data)
    {
        $tag_ids = $data['tag_ids'];
        $feed['content'] = $data['content'];
        $feed['html'] = Tool::markdown2Html($data['content']);
        // 如果没有描述;则截取文章内容的前200字作为描述
        if (empty($data['description'])) {
            $description = preg_replace(array('/[~*>#-]*/', '/!?\[.*\]\(.*\)/', '/\[.*\]/'), '', $data['content']);
            $data['description'] = Tool::subStr($description, 0, 150, true);
        }
        unset($data['tag_ids']);
        unset($data['content']);
        //添加数据
        $result = parent::storeData($data);
        Tool::bdPush($result);
        if ($result) {
            // 给文章添加标签
            $articleTag = new ArticleTag;
            $articleTag->addTagIds($result, $tag_ids);
            // 保存feed
            Feed::query()->create([
                'target_type' => Feed::TYPE_ARTICLE,
                'target_id' => $result,
                'content' => $feed['content'],
                'html' => $feed['html'],
            ]);
            Tool::syncRank($result);
            return $result;
        } else {
            return false;
        }
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateData($id, $data)
    {
        $tag_ids = $data['tag_ids'];
        $feed['content'] = $data['content'];
        $feed['html'] = Tool::markdown2Html($data['content']);
        // 如果没有描述;则截取文章内容的前150字作为描述
        if (empty($data['description'])) {
            $description = preg_replace(array('/[~*>#-]*/', '/!?\[.*\]\(.*\)/', '/\[.*\]/'), '', $data['content']);
            $data['description'] = Tool::subStr($description, 0, 150, true);
        }
        unset($data['tag_ids']);
        unset($data['content']);
        $result = parent::updateData(['id' => $id], $data);
        if ($result) {
            $articleTagModel = new ArticleTag;
            $articleTagModel->addTagIds($id, $tag_ids);
            // 保存feed
            Feed::query()->where([
                ['target_type', '=', Feed::TYPE_ARTICLE],
                ['target_id', '=', $id]
            ])->update([
                'content' => $feed['content'],
                'html' => $feed['html'],
            ]);
            return $result;
        } else {
            return false;
        }
    }

}
