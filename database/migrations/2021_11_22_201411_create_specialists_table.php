<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialists', function (Blueprint $table) {
            $table->id();
            $table-> unsignedInteger('user_id');
            $table->string('firstName');
            $table->string('lastName');
            $table->enum('gender', ['m', 'f']);
            $table->text('specialization');
            $table->text('work_place');
            $table->string('avatar')->default('default.jpg');
            $table->boolean('status')->default(true);


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
        Schema::dropIfExists('specialists');
    }
}
