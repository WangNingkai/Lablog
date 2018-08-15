<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id')->comment('文章ID');
            $table->unsignedInteger('category_id')->default(0)->comment('分类id');
            $table->string('title')->comment('标题');
            $table->string('author')->comment('作者');
            $table->char('description')->comment('描述');
            $table->string('keywords')->comment('关键词');
            $table->boolean('status')->default(0)->comment('是否发布 1是 0否');
            $table->unsignedInteger('click')->default(0)->comment('点击数');
            $table->boolean('allow_comment')->default(1)->comment('是否允许评论');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
