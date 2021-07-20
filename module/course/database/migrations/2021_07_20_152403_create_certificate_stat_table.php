<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificateStatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificate_stat', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company')->nullable();
            $table->integer('user')->nullable();
            $table->integer('subject')->nullable();
            $table->integer('province')->nullable();
            $table->integer('district')->nullable();
            $table->integer('ward')->nullable();
            $table->string('type')->nullable()->default('personal');
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
        Schema::dropIfExists('certificate_stat');
    }
}
