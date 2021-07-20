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
        Schema::table('certificate', function (Blueprint $table) {
            $table->integer('province')->nullable();
            $table->integer('district')->nullable();
            $table->integer('ward')->nullable();
            $table->string('type')->nullable()->default('personal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('certificate', function (Blueprint $table) {
            $table->dropColumn('province');
            $table->dropColumn('district');
            $table->dropColumn('ward');
            $table->dropColumn('type');
        });
    }
}
