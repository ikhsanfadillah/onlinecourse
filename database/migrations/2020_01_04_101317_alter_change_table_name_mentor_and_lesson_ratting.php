<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterChangeTableNameMentorAndLessonRatting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('mentor_rating', 'mentor_ratings');
        Schema::rename('lesson_rating', 'lesson_ratings');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('mentor_ratings', 'mentor_rating');
        Schema::rename('lesson_ratings', 'lesson_rating');
    }
}
