<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->comment('用户id');
            $table->string('name')->comment('用户名');
            $table->string('avatar')->default('')->comment('用户头像');
            $table->string('email')->unique()->comment('邮箱');
            $table->string('password')->comment('密码');
            $table->rememberToken()->comment('是否记住登录');
            $table->boolean('status')->default(1)->comment('状态 1正常 0限制');
            $table->timestamp('last_login_at')->default('')->comment('最后登录时间');
            $table->string('last_login_ip')->default('')->comment('最后登录IP');
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
        Schema::dropIfExists('users');
    }
}
