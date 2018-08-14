<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NavsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('navs')->delete();

        DB::table('navs')->insert(array (

            0 =>
                array (
                    'id' => 1,
                    'type' => 4,
                    'parent_id' => 0,
                    'name' => '首页',
                    'url' => 'http://lablog.cc',
                    'sort' => 1,
                    'status' => 1,
                    'created_at' => '2018-08-11 09:18:28',
                    'updated_at' => '2018-08-11 09:19:09',
                ),

            1 =>
                array (
                    'id' => 2,
                    'type' => 1,
                    'parent_id' => 0,
                    'name' => '我的栏目',
                    'url' => NULL,
                    'sort' => 2,
                    'status' => 1,
                    'created_at' => '2018-08-10 21:06:06',
                    'updated_at' => '2018-08-11 09:18:39',
                ),

            2 =>
                array (
                    'id' => 3,
                    'type' => 2,
                    'parent_id' => 0,
                    'name' => '归档',
                    'url' => NULL,
                    'sort' => 3,
                    'status' => 1,
                    'created_at' => '2018-08-10 22:57:46',
                    'updated_at' => '2018-08-10 23:30:35',
                ),
            3 =>
                array (
                    'id' => 4,
                    'type' => 0,
                    'parent_id' => 0,
                    'name' => '关于',
                    'url' => NULL,
                    'sort' => 4,
                    'status' => 1,
                    'created_at' => '2018-08-10 21:05:52',
                    'updated_at' => '2018-08-10 22:53:31',
                ),
            4 =>
                array (
                    'id' => 5,
                    'type' => 3,
                    'parent_id' => 4,
                    'name' => '关于站点',
                    'url' => 'http://lablog.cc/page/1',
                    'sort' => 1,
                    'status' => 1,
                    'created_at' => '2018-08-10 21:15:25',
                    'updated_at' => '2018-08-10 21:15:25',
                ),
            5 =>
                array (
                    'id' => 6,
                    'type' => 4,
                    'parent_id' => 0,
                    'name' => '留言',
                    'url' => 'http://lablog.cc/message',
                    'sort' => 5,
                    'status' => 1,
                    'created_at' => '2018-08-10 23:42:11',
                    'updated_at' => '2018-08-11 10:23:24',
                )
        ));


    }
}
