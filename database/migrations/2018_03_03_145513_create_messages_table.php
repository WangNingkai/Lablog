<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname')->comment('昵称');
            $table->string('email')->comment('邮箱');
            $table->string('content')->comment('留言');
            $table->string('reply')->nullable()->comment('站长回复');
            $table->boolean('status')->default(0)->comment('状态');
            $table->string('ip')->comment('留言ip');
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
        Schema::dropIfExists('messages');
    }
}
