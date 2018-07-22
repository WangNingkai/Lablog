<?php

namespace App\Models;


class OauthInfo extends Base
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
