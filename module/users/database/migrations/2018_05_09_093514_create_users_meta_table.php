<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_metas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_id');
            $table->string('meta_key');
            $table->text('meta_value')->nullable();
            $table->enum('status', ['public', 'friend', 'onlyme'])->default('public');
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
        Schema::dropIfExists('users_metas');
    }
}
