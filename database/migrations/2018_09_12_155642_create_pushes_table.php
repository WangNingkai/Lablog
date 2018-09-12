<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pushes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject')->comment('主题');
            $table->text('content')->comment('内容');
            $table->text('target')->comment('目标用户');
            $table->boolean('method')->default(0)->comment('推送方式 0立即 1定时');
            $table->boolean('status')->default(0)->comment('状态');
            $table->timestamp('started_at');
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
        Schema::dropIfExists('pushes');
    }
}
