<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable,HasRoles;

    const ACTIVE = 1;
    const FORBID = 0;

    protected $guard_name = 'web';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status'
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
        return $this->status === self::ACTIVE ? '<a href="javascript:void(0)" class="btn btn-sm btn-success btn-flat">正常</a>' : '<a href="javascript:void(0)" class="btn btn-sm btn-danger btn-flat">禁用</a>';
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
