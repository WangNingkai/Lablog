<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOauthOpenidToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->default('uploads/avatar/default.png')->comment('用户头像');
            $table->string('qq_openid', 40)->default('')->unique()->comment('第三方用户openid');
            $table->string('weibo_openid', 40)->default('')->unique()->comment('第三方用户openid');
            $table->string('github_openid', 40)->default('')->unique()->comment('第三方用户openid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('qq_openid');
            $table->dropColumn('weibo_openid');
            $table->dropColumn('github_openid');
        });
    }
}
