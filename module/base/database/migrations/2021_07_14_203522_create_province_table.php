<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvinceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('province_id');
            $table->string('province_code');
            $table->string('province_name');
        });

        Schema::create('districts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('district_id');
            $table->string('district_value');
            $table->string('district_name');
            $table->integer('province_id');
        });

        Schema::create('wards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ward_id');
            $table->string('ward_name');
            $table->integer('district_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('province');
        Schema::dropIfExists('district');
        Schema::dropIfExists('ward');
    }
}
