<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Config;
use App\Models\Tag;
use App\Models\Category;

class DefaultDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
                $user = User::create(
            [
                'name' => 'user',
                'email' => 'test@test.com',
                'password' => bcrypt(12345678),
                'status' => 1,
            ]
        );

        \DB::table('configs')->delete();
        \DB::table('configs')->insert([
            0 => [
                'id' => 1,
                'name' => 'site_status',
                'value' => '1',
                'created_at' => '2017-10-25 12:12:00',
                'updated_at' => '2017-10-25 12:12:00',

            ],
            1 => [
                'id' => 2,
                'name' => 'site_close_word',
                'value' => '站点维护，临时关闭',
                'created_at' => '2017-10-25 12:12:00',
                'updated_at' => '2017-10-25 12:12:00',

            ],
            2 => [
                'id' => 3,
                'name' => 'site_name',
                'value' => 'NKBLOG',
                'created_at' => '2017-10-25 12:12:00',
                'updated_at' => '2017-10-25 12:12:00',

            ],
            3 => [
                'id' => 4,
                'name' => 'site_title',
                'value' => 'imwnk',
                'created_at' => '2017-10-25 12:12:00',
                'updated_at' => '2017-10-25 12:12:00',

            ],
            4 => [
                'id' => 5,
                'name' => 'site_keywords',
                'value' => 'blog',
                'created_at' => '2017-10-25 12:12:00',
                'updated_at' => '2017-10-25 12:12:00',

            ],
            5 => [
                'id' => 6,
                'name' => 'site_description',
                'value' => '个人博客',
                'created_at' => '2017-10-25 12:12:00',
                'updated_at' => '2017-10-25 12:12:00',

            ],
            6 => [
                'id' => 7,
                'name' => 'site_icp_num',
                'value' => '苏12345678',
                'created_at' => '2017-10-25 12:12:00',
                'updated_at' => '2017-10-25 12:12:00',

            ],
            7 => [
                'id' => 8,
                'name' => 'site_admin',
                'value' => 'NK.W',
                'created_at' => '2017-10-25 12:12:00',
                'updated_at' => '2017-10-25 12:12:00',

            ],
            8 => [
                'id' => 9,
                'name' => 'site_admin_mail',
                'value' => 'admin@youmail.com',
                'created_at' => '2017-10-25 12:12:00',
                'updated_at' => '2017-10-25 12:12:00',

            ],
            9 => [
                'id' => 10,
                'name' => 'site_admin_weibo',
                'value' => 'http://your_weibo',
                'created_at' => '2017-10-25 12:12:00',
                'updated_at' => '2017-10-25 12:12:00',

            ],
            10 => [
                'id' => 11,
                'name' => 'site_admin_github',
                'value' => 'http://your_github',
                'created_at' => '2017-10-25 12:12:00',
                'updated_at' => '2017-10-25 12:12:00',

            ],
            11 => [
                'id' => 12,
                'name' => 'site_admin_info',
                'value' => '个人简介个人简介个人简介个人简介个人简介',
                'created_at' => '2017-10-25 12:12:00',
                'updated_at' => '2017-10-25 12:12:00',

            ],
            12 => [
                'id' => 13,
                'name' => 'site_info',
                'value' => '站点消息',
                'created_at' => '2017-10-25 12:12:00',
                'updated_at' => '2017-10-25 12:12:00',

            ],
            13 => [
                'id' => 14,
                'name' => 'site_about',
                'value' => '关于',
                'created_at' => '2017-10-25 12:12:00',
                'updated_at' => '2017-10-25 12:12:00',

            ],
        ]);
        \DB::table('tags')->delete();
        \DB::table('tags')->insert([
            0 => [
                'id' => 1,
                'name' => '默认',
                'flag' => 'default',
                'created_at' => '2017-10-25 12:12:00',
                'updated_at' => '2017-10-25 12:12:00',
            ],
        ]);
        \DB::table('categories')->delete();
        \DB::table('categories')->insert([
            0 => [
                'id' => 1,
                'pid' => 0,
                'name' => '默认',
                'flag' => 'default',
                'keywords' => 'default',
                'description' => 'default',
                'created_at' => '2017-10-25 12:12:00',
                'updated_at' => '2017-10-25 12:12:00',
            ],
        ]);
    }
}
