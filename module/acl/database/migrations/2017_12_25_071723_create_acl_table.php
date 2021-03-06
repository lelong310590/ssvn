<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAclTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('roles', function (Blueprint $table) {
		    $table->engine = 'InnoDB';
		    $table->increments('id');
		    $table->string('name')->unique();
		    $table->string('display_name')->nullable();
		    $table->string('description')->nullable();
		    $table->timestamps();
	    });
	
	    Schema::create('role_user', function (Blueprint $table) {
		    $table->engine = 'InnoDB';
		    $table->integer('user_id')->unsigned();
		    $table->integer('role_id')->unsigned();
		    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
		    $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');
		    $table->primary(['user_id', 'role_id']);
	    });
	
	    Schema::create('permissions', function (Blueprint $table) {
		    $table->engine = 'InnoDB';
		    $table->increments('id');
		    $table->string('name')->unique();
		    $table->string('display_name')->nullable();
		    $table->string('description')->nullable();
		    $table->string('module')->nullable();
		    $table->timestamps();
	    });
	
	    Schema::create('permission_role', function (Blueprint $table) {
		    $table->engine = 'InnoDB';
		    $table->integer('role_id')->unsigned();
		    $table->integer('permission_id')->unsigned();
		    $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');
		    $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade')->onUpdate('cascade');
		    $table->primary(['role_id', 'permission_id']);
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::dropIfExists('roles');
	    Schema::dropIfExists('role_user');
	    Schema::dropIfExists('permissions');
	    Schema::dropIfExists('permission_role');
    }
}
