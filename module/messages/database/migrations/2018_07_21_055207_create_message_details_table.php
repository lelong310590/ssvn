<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateMessageDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sender')->unsigned();
            $table->foreign('sender')->references('id')->on('users');
            $table->integer('message_id')->unsigned();
            $table->foreign('message_id')->references('id')->on('messages');
            $table->text('message');
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
        Schema::dropIfExists('message_details');
    }
}
