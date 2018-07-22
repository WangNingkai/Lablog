<?php

namespace App\Models;


class OauthInfo extends Base
{
    const TYPE_QQ     = 1;
    const TYPE_WEIBO  = 2;
    const TYPE_GITHUB = 3;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
