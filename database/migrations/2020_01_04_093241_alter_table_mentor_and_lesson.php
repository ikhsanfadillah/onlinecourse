<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableMentorAndLesson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('mentors', function (Blueprint $table) {
            $table->tinyInteger('rating_avg')->default(0);
        });
        Schema::table('lessons', function (Blueprint $table) {
            $table->tinyInteger('rating_avg')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mentors', function (Blueprint $table) {
            $table->dropColumn(['rating_avg']);
        });
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn(['rating_avg']);
        });
    }
}
