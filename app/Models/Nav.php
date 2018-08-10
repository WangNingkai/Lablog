<?php

namespace App\Models;

class
Nav extends Base
{
    # todo:
    # 1.用户添加菜单，选择菜单类型。
    # 2.用户编辑菜单 ,可编辑名称、类型、内容
    # 3.菜单为单页和链接类型可以，存在父级菜单，其他菜单父级为0 全局只支持最多二级菜单
    # 4.后台添加单页。在菜单中可以选择显示、也可分享页面给用户


    const TYPE = [
        0 => '空菜单',
        1 => '分类菜单',
        2 => '归档',
        3 => '单页',
        4 => '外链',
    ];
    const TYPE_EMPTY = 0;    // 普通菜单 可添加单页 链接
    const TYPE_MENU = 1;     // 分类菜单（固定存在的）
    const TYPE_ARCHIVE = 2;  // 归档页面（固定存在的）
    const TYPE_PAGE = 3;     // 单页（url为单页链接）
    const TYPE_LINK = 4;     // 链接（直接添加链接）
    const LIMIT_NUM = 14;    // 最大菜单数
    const STATUS_DISPLAY = 1;
    const STATUS_HIDE = 0;


    /**
     * 递归获取树形索引
     * @param integer
     * @param integer
     * @return array 角色数组
     */
    public function getTreeIndex($id = 0, $deep = 0) {
        static $tempArr = [];
        $data = $this->query()->where('parent_id', $id)->orderBy('sort', 'asc')->get();
        foreach ($data as $k => $v) {
            $v->deep = $deep;
            $v->name = str_repeat("&nbsp;&nbsp;", $v->deep * 2) . '|--' . $v->name;
            $tempArr[] = $v;
            $this->getTreeIndex($v->id, $deep + 1);
        }
        return $tempArr;
    }

    public function getTypeNameAttribute()
    {
        $result = "";
        foreach (self::TYPE as $key => $type)
        {
            if($this->attributes['type'] == $key)
            {
                $result = $type;
            }
        }
        return $result;
    }

    public function getStatusTagAttribute()
    {
        return $this->attributes['status'] === self::STATUS_DISPLAY ? '<a href="javascript:void(0)" class="btn btn-sm btn-success btn-flat">显示</a>' : '<a href="javascript:void(0)" class="btn btn-sm btn-danger btn-flat">隐藏</a>';
    }
}
