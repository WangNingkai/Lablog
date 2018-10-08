<?php

namespace App\Models;


class Link extends Base
{
    protected $fillable = ['name', 'url', 'sort'];

    /**
     * 添加数据
     *
     * @param array $data
     * @return bool
     */
    public function storeData($data)
    {
        return parent::storeData($data);
    }

    /**
     * 修改数据
     *
     * @param array $map
     * @param array $data
     * @return bool
     */
    public function updateData($map, $data)
    {
        return parent::updateData($map, $data);
    }

    /**
     * 给url添加http 或者删除/
     *
     * @param  string $value
     * @return string
     */
    public function setUrlAttribute($value)
    {
        // 如果没有http或者https 则补上http
        if (strpos($value, 'http') === false || strpos($value, 'https') === false) {
            $value = 'http://' . $value;
        }
        // 删除右侧的/
        $value = rtrim($value, '/');
        $this->attributes['url'] = strtolower($value);
    }
}
