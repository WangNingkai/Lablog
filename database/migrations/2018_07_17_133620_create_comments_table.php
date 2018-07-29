<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('article_id')->default(0)->comment('文章id');
            $table->string('nickname')->comment('昵称');
            $table->string('email')->comment('邮箱');
            $table->string('content')->comment('留言');
            $table->string('reply')->nullable()->comment('回复');
            $table->boolean('status')->default(0)->comment('状态');
            $table->string('ip')->comment('评论ip');
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
        Schema::dropIfExists('comments');
    }
}
