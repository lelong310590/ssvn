<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressToClasslevel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('classlevel', function (Blueprint $table) {
            $table->string('address')->nullable();
            $table->string('owner_cid')->nullable();
            $table->integer('province')->nullable();
            $table->integer('district')->nullable();
            $table->integer('ward')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('classlevel', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('owner_cid');
            $table->dropColumn('province');
            $table->dropColumn('district');
            $table->dropColumn('ward');
        });
    }
}
