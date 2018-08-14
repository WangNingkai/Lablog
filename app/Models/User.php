<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable,HasRoles,SoftDeletes;

    const ACTIVE = 1;
    const FORBID = 0;
    const SUPERUSER = 1; // 超级管理员ID
    const SUPERADMIN = '超级管理员'; // 超级管理员角色组

    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'avatar','email', 'password', 'status', 'last_login_at','last_login_ip'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oauthInfos()
    {
        return $this->hasMany(OauthInfo::class);
    }

    public function getStatusTagAttribute()
    {
        return $this->attributes['status'] === self::ACTIVE ? '<a href="javascript:void(0)" class="btn btn-sm btn-success btn-flat">正常</a>' : '<a href="javascript:void(0)" class="btn btn-sm btn-danger btn-flat">禁用</a>';
    }

    public function getAllRolesTagAttribute()
    {
        $role_tags = '';
        $roles = Role::all();
        foreach($roles as $role)
        {
            if($this->hasRole($role->name))
            {
                $role_tags.='&nbsp;<a href="javascript:void(0)" class="btn btn-sm btn-success btn-flat">'.$role->name.'</a>';
            }
        }
        return $role_tags;
    }
}
