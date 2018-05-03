<?php

namespace App\Models;


class Category extends Base
{
    protected $fillable = ['name', 'flag', 'pid', 'keywords', 'description', 'sort'];

    public function getNameByPid($pid)
    {
        if (0 === $pid) {
            return '主栏目';
        }
        return $data = $this->where('id', $pid)->pluck('name')->first();
    }

    /**
     * 删除数据
     *
     * @param array $map
     * @return bool
     */
    public function destroyData($map)
    {
        // 先获取分类id
        $categoryIdArray = $this
            ->whereMap($map)
            ->pluck('id')
            ->toArray();
        foreach ($categoryIdArray as $value) {
            if (0 === $this->where('id', $value)->pluck('pid')->first()) {
                $categoryCount = $this->where('pid', $value)->count();
                if (0 !== $categoryCount) {
                    show_message('请先删除所选分类下的子分类', false);
                    return false;
                }
            }
        }
        // 获取分类下的文章数
        $articleCount = Article::whereIn('category_id', $categoryIdArray)->count();
        // 如果分类下存在文章；则需要下删除文章
        if ($articleCount !== 0) {
            show_message('请先删除所选分类下的文章', false);
            return false;
        }
        // 删除分类
        return parent::destroyData($map);
    }
}
