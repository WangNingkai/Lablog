<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $user = User::query()->find(User::SUPERUSER);
        // 重置角色和权限的缓存
        app()['cache']->forget('spatie.permission.cache');
        // 创建角色并赋予超级管理员角色
        Role::create(['name' => User::SUPERADMIN]);
        $user->assignRole(User::SUPERADMIN);

    }
}
