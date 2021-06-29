<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationColumnToCourseCurriculumnItemsReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
//        Schema::table('course_curriculum_items_reports', function (Blueprint $table) {
//            $table->foreign('course_id')->references('id')->on('course');
//            $table->foreign('lecture_id')->references('id')->on('course_curriculum_items');
//            $table->foreign('user_id')->references('id')->on('users');
//            $table->foreign('question_id')->references('id')->on('questions');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
//        Schema::table('course_curriculum_items_reports', function (Blueprint $table) {
//            $table->dropForeign('course_id');
//            $table->dropForeign('lecture_id');
//            $table->dropForeign('user_id');
//            $table->dropForeign('question_id');
//        });
    }
}
