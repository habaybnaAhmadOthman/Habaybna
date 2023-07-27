<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommingSoonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comming_soons', function (Blueprint $table) {
            $table->id();
            $table->string('path')->nullable();
            $table->boolean('status')->nullable();
            $table->string('order')->nullable();
            $table->unsignedInteger('course_id')->nullable();
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
        Schema::dropIfExists('comming_soons');
    }
}
