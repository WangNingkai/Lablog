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
            $table->string('operator')->nullable()->comment('操作者');;
            $table->string('operation')->nullable()->comment('操作');;
            $table->string('ip')->nullable()->comment('ip');;
            $table->integer('operation_time')->nullable()->comment('时间');;
            $table->string('address')->nullable()->comment('地址');;
            $table->string('device')->nullable()->comment('设备');;
            $table->string('browser')->nullable()->comment('浏览器');;
            $table->string('platform')->nullable()->comment('平台');;
            $table->string('language')->nullable()->comment('语言');;
            $table->string('device_type')->nullable()->comment('设备类型');;
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
