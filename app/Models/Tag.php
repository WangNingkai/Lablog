<?php

namespace App\Models;

use App\Helpers\Extensions\Tool;

class Tag extends Base
{
    protected $fillable = ['name', 'flag'];

    /**
     * 多对多关联文章表
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_tags');
    }

    /**
     * 删除数据
     *
     * @param array $map
     *
     * @return bool
     */
    public function destroyData($map)
    {
        // 先获取分类id
        $tagIdArray = $this
            ->query()
            ->whereMap($map)
            ->pluck('id')
            ->toArray();
        // 获取分类下的文章数
        $articleCount = ArticleTag::query()->whereIn('tag_id', $tagIdArray)
            ->count();
        // 如果分类下存在文章；则需要下删除文章
        if (0 !== $articleCount) {
            Tool::showMessage('请先删除此标签下的文章', false);

            return false;
        }

        return parent::destroyData($map);
    }
}
