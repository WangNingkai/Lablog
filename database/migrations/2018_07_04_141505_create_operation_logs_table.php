<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operation_logs', function (Blueprint $table) {
            // id operater operation ip operation_time  address device  browser platform language device_type
            $table->increments('id');
            $table->string('operator')->comment('操作者');;
            $table->string('operation')->comment('操作');;
            $table->string('ip')->comment('ip');;
            $table->integer('operation_time')->comment('时间');;
            $table->string('address')->comment('地址');;
            $table->string('device')->comment('设备');;
            $table->string('browser')->comment('浏览器');;
            $table->string('platform')->comment('平台');;
            $table->string('language')->comment('语言');;
            $table->string('device_type')->comment('设备类型');;
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
        Schema::dropIfExists('operation_logs');
    }
}
