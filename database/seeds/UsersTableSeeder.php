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
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin',
                'avatar' => '/uploads/avatar/default.png',
                'email' => 'admin@admin.com',
                'password' => bcrypt(12345678),
                'remember_token' => NULL,
                'status' => 1,
                'last_login_at' => '2018-01-01 00:00:00',
                'last_login_ip' => '192.168.1.1',
                'created_at' => '2018-01-01 00:00:00',
                'updated_at' => '2018-01-01 00:00:00',
                'deleted_at' => NULL,
            )
        ));

        $user = User::query()->find(User::SUPERUSER);
        // 重置角色和权限的缓存
        app()['cache']->forget('spatie.permission.cache');
        // 创建角色并赋予超级管理员角色
        Role::create(['name' => User::SUPERADMIN]);
        $user->assignRole(User::SUPERADMIN);
        
    }
}
