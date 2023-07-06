<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table-> unsignedInteger('user_id');
            $table->string('name')->nullable();
            $table->enum('gender', ['m', 'f']);
            $table->boolean('status')->default(true);
            $table->date('dob');
            $table->text('interests')->nullable();
            $table->text('other_info')->nullable();
            $table->string('photo')->default('default.jpg');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('children');
    }
}
