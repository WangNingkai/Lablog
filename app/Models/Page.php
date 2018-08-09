<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;
    # 单页模块 存放关于页面等单一页面。友链也可以设置进去
    const STATUS_DISPLAY = 1;
    const STATUS_HIDE = 0;
}
