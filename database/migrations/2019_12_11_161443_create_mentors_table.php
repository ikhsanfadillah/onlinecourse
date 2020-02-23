<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMentorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentors', function (Blueprint $table) {
            $table->unsignedBigInteger('mentor_id');
            $table->unsignedBigInteger('primary_photo')->nullable();
            $table->unsignedBigInteger('highlight_video')->nullable();
            $table->string('profesi');
            $table->text('desc');
            $table->decimal('price',17,2)->default(0);
            $table->unsignedBigInteger('description_photo')->nullable();
            $table->unsignedBigInteger('visit_count')->default(0);

            $table->foreign('mentor_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->primary('mentor_id', 'mentor_has_user_mentor_id_user_id_primary');
        });

        Schema::create('mentor_rating', function (Blueprint $table) {
            $table->unsignedBigInteger('mentor_id');
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('rating')->default(5);
            $table->text('testimonial')->nullable();
            $table->boolean('is_show')->default(0);
            $table->timestamps();

            $table->foreign('mentor_id')
                ->references('mentor_id')
                ->on('mentors')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->primary(['mentor_id', 'user_id'], 'mentor_has_rating_mentor_id_user_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mentors');
        Schema::dropIfExists('mentor_rating');
    }
}
