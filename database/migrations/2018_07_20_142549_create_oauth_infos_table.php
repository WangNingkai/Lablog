<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_infos', function (Blueprint $table) {
            $table->increments('id')->comment('主键id');
            $table->unsignedInteger('user_id')->comment('绑定的用户id');
            $table->boolean('type')->default(1)->comment('类型 1：QQ  2：新浪微博 3：github');
            $table->string('name', 30)->comment('第三方昵称');
            $table->string('avatar')->comment('头像');
            $table->string('openid', 40)->comment('第三方用户id');
            $table->string('access_token')->comment('access_token token');
            $table->string('last_login_ip', 16)->comment('最后登录ip');
            $table->unsignedInteger('login_times')->default(0)->comment('登录次数');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oauth_infos');
    }
}
