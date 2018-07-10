<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id')->comment('主键ID');
            $table->unsignedInteger('pid')->default(0)->comment('父级ID');
            $table->string('name', 15)->default('')->comment('栏目名');
            $table->string('flag')->default('')->comment('标签标识');
            $table->string('keywords')->default('')->nullable()->comment('关键词');
            $table->string('description')->default('')->nullable()->comment('描述');
            $table->boolean('sort')->default(0)->comment('排序');
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
        Schema::dropIfExists('categories');
    }
}
