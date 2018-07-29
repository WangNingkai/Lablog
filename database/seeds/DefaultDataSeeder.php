<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DefaultDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        $user = User::create(
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt(12345678),
                'status' => 1,
            ]
        );
        // 重置角色和权限的缓存
        app()['cache']->forget('spatie.permission.cache');
        // 创建角色并赋予超级管理员角色
        Role::create(['name' => User::SUPERADMIN]);
        $user->assignRole(User::SUPERADMIN);

        DB::table('configs')->truncate();
        DB::table('configs')->insert([
            0 => [
                'id' => 1,
                'name' => 'site_status',
                'value' => '1',
                'created_at' => '2018-01-01 00:00:00',
                'updated_at' => '2018-01-01 00:00:00',

            ],
            1 => [
                'id' => 2,
                'name' => 'site_close_word',
                'value' => '站点维护，临时关闭',
                'created_at' => '2018-01-01 00:00:00',
                'updated_at' => '2018-01-01 00:00:00',

            ],
            2 => [
                'id' => 3,
                'name' => 'site_name',
                'value' => 'NKBLOG',
                'created_at' => '2018-01-01 00:00:00',
                'updated_at' => '2018-01-01 00:00:00',

            ],
            3 => [
                'id' => 4,
                'name' => 'site_title',
                'value' => 'imwnk',
                'created_at' => '2018-01-01 00:00:00',
                'updated_at' => '2018-01-01 00:00:00',

            ],
            4 => [
                'id' => 5,
                'name' => 'site_keywords',
                'value' => 'blog',
                'created_at' => '2018-01-01 00:00:00',
                'updated_at' => '2018-01-01 00:00:00',

            ],
            5 => [
                'id' => 6,
                'name' => 'site_description',
                'value' => '个人博客',
                'created_at' => '2018-01-01 00:00:00',
                'updated_at' => '2018-01-01 00:00:00',

            ],
            6 => [
                'id' => 7,
                'name' => 'site_icp_num',
                'value' => '苏12345678',
                'created_at' => '2018-01-01 00:00:00',
                'updated_at' => '2018-01-01 00:00:00',

            ],
            7 => [
                'id' => 8,
                'name' => 'site_admin',
                'value' => 'NK.W',
                'created_at' => '2018-01-01 00:00:00',
                'updated_at' => '2018-01-01 00:00:00',

            ],
            8 => [
                'id' => 9,
                'name' => 'site_admin_mail',
                'value' => 'admin@youmail.com',
                'created_at' => '2018-01-01 00:00:00',
                'updated_at' => '2018-01-01 00:00:00',

            ],
            9 => [
                'id' => 10,
                'name' => 'site_admin_weibo',
                'value' => 'http://your_weibo',
                'created_at' => '2018-01-01 00:00:00',
                'updated_at' => '2018-01-01 00:00:00',

            ],
            10 => [
                'id' => 11,
                'name' => 'site_admin_github',
                'value' => 'http://your_github',
                'created_at' => '2018-01-01 00:00:00',
                'updated_at' => '2018-01-01 00:00:00',

            ],
            11 => [
                'id' => 12,
                'name' => 'site_admin_info',
                'value' => '个人简介个人简介个人简介个人简介个人简介',
                'created_at' => '2018-01-01 00:00:00',
                'updated_at' => '2018-01-01 00:00:00',

            ],
            12 => [
                'id' => 13,
                'name' => 'site_info',
                'value' => '站点消息',
                'created_at' => '2018-01-01 00:00:00',
                'updated_at' => '2018-01-01 00:00:00',

            ],
            13 => [
                'id' => 14,
                'name' => 'site_about',
                'value' => '关于',
                'created_at' => '2018-01-01 00:00:00',
                'updated_at' => '2018-01-01 00:00:00',

            ],
            14 => [
                'id' => 15,
                'name' => 'site_mailto_admin',
                'value' => 'admin@admin.com',
                'created_at' => '2018-01-01 00:00:00',
                'updated_at' => '2018-01-01 00:00:00',

            ],
            15 => [
                'id' => 16,
                'name' => 'site_110beian_num',
                'value' => '苏公安12345678',
                'created_at' => '2018-01-01 00:00:00',
                'updated_at' => '2018-01-01 00:00:00',

            ],
            16 => [
                'id' => 17,
                'name' => 'site_110beian_link',
                'value' => 'http://',
                'created_at' => '2018-01-01 00:00:00',
                'updated_at' => '2018-01-01 00:00:00',

            ],
            17 => [
                'id' => 18,
                'name' => 'site_admin_avattar',
                'value' => 'http://',
                'created_at' => '2018-01-01 00:00:00',
                'updated_at' => '2018-01-01 00:00:00',

            ],
        ]);
        DB::table('tags')->truncate();
        DB::table('tags')->insert([
            0 => [
                'id' => 1,
                'name' => '默认',
                'flag' => 'default',
                'created_at' => '2018-01-01 00:00:00',
                'updated_at' => '2018-01-01 00:00:00',
            ],
        ]);
        DB::table('categories')->truncate();
        DB::table('categories')->insert([
            0 => [
                'id' => 1,
                'pid' => 0,
                'name' => '默认',
                'flag' => 'default',
                'keywords' => 'default',
                'description' => 'default',
                'created_at' => '2018-01-01 00:00:00',
                'updated_at' => '2018-01-01 00:00:00',
            ],
        ]);
    }
}
