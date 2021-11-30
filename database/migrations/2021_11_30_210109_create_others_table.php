<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOthersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('others', function (Blueprint $table) {
            $table->id();
            $table-> unsignedInteger('user_id');
            $table->string('firstName');
            $table->string('lastName');
            $table->enum('gender', ['m', 'f']);
            $table->text('specialization');
            $table->text('work_place');
            $table->string('avatar')->default('default.jpg');
            $table->boolean('status')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('others');
    }
}
