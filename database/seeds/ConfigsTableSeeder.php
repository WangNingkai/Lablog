<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('configs')->delete();

        DB::table('configs')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'site_status',
                    'value' => '1',
                    'created_at' => '2018-01-01 00:00:00',
                    'updated_at' => '2018-01-01 00:00:00',
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'site_close_word',
                    'value' => '站点维护，临时关闭',
                    'created_at' => '2018-01-01 00:00:00',
                    'updated_at' => '2018-01-01 00:00:00',
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'site_name',
                    'value' => 'xxx',
                    'created_at' => '2018-01-01 00:00:00',
                    'updated_at' => '2018-01-01 00:00:00',
                ),
            3 =>
                array (
                    'id' => 4,
                    'name' => 'site_title',
                    'value' => 'xxx',
                    'created_at' => '2018-01-01 00:00:00',
                    'updated_at' => '2018-01-01 00:00:00',
                ),
            4 =>
                array (
                    'id' => 5,
                    'name' => 'site_keywords',
                    'value' => 'xx,xxx,个人博客,lablog,技术分享',
                    'created_at' => '2018-01-01 00:00:00',
                    'updated_at' => '2018-01-01 00:00:00',
                ),
            5 =>
                array (
                    'id' => 6,
                    'name' => 'site_description',
                    'value' => 'xxx的个人技术博客',
                    'created_at' => '2018-01-01 00:00:00',
                    'updated_at' => '2018-01-01 00:00:00',
                ),
            6 =>
                array (
                    'id' => 7,
                    'name' => 'site_icp_num',
                    'value' => '苏ICP备xxx号',
                    'created_at' => '2018-01-01 00:00:00',
                    'updated_at' => '2018-01-01 00:00:00',
                ),
            7 =>
                array (
                    'id' => 8,
                    'name' => 'site_admin',
                    'value' => 'xxx',
                    'created_at' => '2018-01-01 00:00:00',
                    'updated_at' => '2018-01-01 00:00:00',
                ),
            8 =>
                array (
                    'id' => 9,
                    'name' => 'site_admin_mail',
                    'value' => '//mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=xxx',
                    'created_at' => '2018-01-01 00:00:00',
                    'updated_at' => '2018-01-01 00:00:00',
                ),
            9 =>
                array (
                    'id' => 10,
                    'name' => 'site_admin_weibo',
                    'value' => '//weibo.com/xxx',
                    'created_at' => '2018-01-01 00:00:00',
                    'updated_at' => '2018-01-01 00:00:00',
                ),
            10 =>
                array (
                    'id' => 11,
                    'name' => 'site_admin_github',
                    'value' => '//gitee.com/xxx',
                    'created_at' => '2018-01-01 00:00:00',
                    'updated_at' => '2018-01-01 00:00:00',
                ),
            11 =>
                array (
                    'id' => 12,
                    'name' => 'site_admin_info',
                    'value' => 'PHP ARTISAN.',
                    'created_at' => '2018-01-01 00:00:00',
                    'updated_at' => '2018-01-01 00:00:00',
                ),
            12 =>
                array (
                    'id' => 13,
                    'name' => 'site_info',
                    'value' => '本站发布的系统与软件仅为个人学习测试使用，请在下载后24小时内删除，不得用于任何商业用途，否则后果自负，请支持购买正版软件！如侵犯到您的权益,请及时通知我们,我们会及时处理。',
                    'created_at' => '2018-01-01 00:00:00',
                    'updated_at' => '2018-01-01 00:00:00',
                ),
            13 =>
                array (
                    'id' => 14,
                    'name' => 'site_admin_avatar',
                    'value' => 'http://xxx/xxx/xxx/xxx.jpg',
                    'created_at' => '2018-01-01 00:00:00',
                    'updated_at' => '2018-01-01 00:00:00',
                ),
            14 =>
                array (
                    'id' => 15,
                    'name' => 'site_mailto_admin',
                    'value' => 'xxx@qq.com',
                    'created_at' => '2018-01-01 00:00:00',
                    'updated_at' => '2018-01-01 00:00:00',
                ),
            15 =>
                array (
                    'id' => 16,
                    'name' => 'site_110beian_num',
                    'value' => '苏公网安备 111111111111号',
                    'created_at' => '2018-01-01 00:00:00',
                    'updated_at' => '2018-01-01 00:00:00',
                ),
            16 =>
                array (
                    'id' => 17,
                    'name' => 'site_110beian_link',
                    'value' => 'http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=xxx',
                    'created_at' => '2018-01-01 00:00:00',
                    'updated_at' => '2018-01-01 00:00:00',
                ),
            17 =>
                array (
                    'id' => 18,
                    'name' => 'site_allow_comment',
                    'value' => '1',
                    'created_at' => '2018-01-01 00:00:00',
                    'updated_at' => '2018-01-01 00:00:00',
                ),
            18 =>
                array (
                    'id' => 19,
                    'name' => 'site_allow_message',
                    'value' => '1',
                    'created_at' => '2018-01-01 00:00:00',
                    'updated_at' => '2018-01-01 00:00:00',
                ),
            19 =>
                array (
                    'id' => 20,
                    'name' => 'site_allow_subscribe',
                    'value' => '',
                    'created_at' => '2018-01-01 00:00:00',
                    'updated_at' => '2018-01-01 00:00:00',
                )
        ));


    }
}
