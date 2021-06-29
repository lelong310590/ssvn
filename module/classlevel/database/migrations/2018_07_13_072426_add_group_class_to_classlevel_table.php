<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGroupClassToClasslevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classlevel', function (Blueprint $table) {
            $table->enum('group', ['primary', 'secondary', 'high'])->default('primary')->after('slug')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classlevel', function (Blueprint $table) {
            $table->dropColumn('group');
        });
    }
}
