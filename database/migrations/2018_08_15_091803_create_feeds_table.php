<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feeds', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('target_type')->comment('类型0文章1单页');
            $table->unsignedInteger('target_id')->comment('关联类型ID');
            $table->mediumText('content')->comment('markdown内容');
            $table->mediumText('html')->comment('markdown转的html内容');
            $table->timestamps();
            $table->unique(['target_type', 'target_id'],'idx_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feeds');
    }
}
