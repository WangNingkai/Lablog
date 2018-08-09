<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;
    # 单页模块
    const STATUS_DISPLAY = 1;
    const STATUS_HIDE = 0;
}
