<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('message_id')->unsigned();
            $table->foreign('message_id')->references('id')->on('messages');
            $table->enum('seen', ['active', 'disable'])->default('disable');
            $table->enum('type', ['star', 'normal', 'block'])->default('normal');
            $table->enum('status', ['active', 'disable'])->default('active');
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
        Schema::dropIfExists('message_lists');
    }
}
