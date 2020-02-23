<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('mentor_id');
            $table->unsignedBigInteger('thumbnail_photo');
            $table->morphs('lessonable');
            $table->string('title');
            $table->text('desc');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('mentor_id')
                ->references('mentor_id')
                ->on('mentors')
                ->onDelete('cascade');

        });


        Schema::create('lesson_rating', function (Blueprint $table) {
            $table->unsignedBigInteger('lesson_id');
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('rating')->default(5);
            $table->text('testimonial')->nullable();
            $table->boolean('is_show')->default(0);
            $table->timestamps();

            $table->foreign('lesson_id')
                ->references('id')
                ->on('lessons')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->primary(['lesson_id', 'user_id'], 'lesson_has_rating_lesson_id_user_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('lesson_rating');
    }
}
