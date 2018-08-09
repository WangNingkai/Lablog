<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navs', function (Blueprint $table) {
            $table->increments('id')->comment('菜单ID');
            $table->string('name')->default('')->comment('菜单名');
            $table->string('url')->nullable()->comment('链接');
            $table->boolean('type')->default(1)->comment('菜单类型1分类菜单2归档3单页4链接');
            $table->boolean('sort')->default(1)->comment('排序');
            $table->boolean('status')->default(0)->comment('状态');
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
        Schema::dropIfExists('navs');
    }
}
