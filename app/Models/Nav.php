<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nav extends Model
{
    const TYPE_EMPTY = 0; // 空菜单 可添加单页，链接
    const TYPE_MENU = 1; // 分类菜单
    const TYPE_ARCHIVE = 2; // 归档页面
    const TYPE_PAGE = 3; // 单页
    const TYPE_LINK = 4; // 链接
    const LIMIT_NUM = 14; // 最大菜单数
}
