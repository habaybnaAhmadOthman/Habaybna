<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->text('courseTitle')->nullable();
            $table->text('courseDescription')->nullable();
            $table->integer('category_id')->nullable();
            $table->text('whatWeLearn')->nullable();
            $table->integer('instructors')->nullable();
            $table->unsignedInteger('price')->nullable();
            $table->boolean('is_publish')->default(1);
            $table->string('cover_photo')->nullable();
            $table->string('promo_video')->nullable();
            $table->boolean('is_free')->default(0);
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
        Schema::dropIfExists('courses');
    }
}
