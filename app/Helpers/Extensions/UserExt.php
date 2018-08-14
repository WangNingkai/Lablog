<?php

namespace App\Helpers\Extensions;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserExt
{
    /**
     * 获取登录用户
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public static function currentUser()
    {
        $uid = Auth::id();
        return User::query()->findOrFail($uid);
    }

    /**
     * 获取登录用户某属性值
     * @param $key
     * @return mixed
     */
    public static function getAttribute($key)
    {
        $user = self::currentUser();
        return $user->getAttributeValue($key);
    }

    public static function getBy()
    {

    }
}
