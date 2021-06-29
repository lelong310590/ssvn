<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password')->nullable();
	        $table->string('thumbnail')->nullable();
	        $table->string('first_name')->nullable();
	        $table->string('last_name')->nullable();
	        $table->string('phone')->nullable();
	        $table->enum('newsletter', ['active', 'disable'])->default('disable');
	        $table->enum('status', ['active', 'disable'])->default('disable');
	        $table->enum('sex', ['male', 'female', 'other']);
            $table->integer('sold_course')->default(0);
	        $table->longText('biography')->nullable();
	        $table->rememberToken();
            $table->timestamps();
        });
	
	    Schema::create('password_resets', function (Blueprint $table) {
		    $table->string('email')->index();
		    $table->string('token');
		    $table->timestamp('created_at')->nullable();
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_resets');
    }
}
