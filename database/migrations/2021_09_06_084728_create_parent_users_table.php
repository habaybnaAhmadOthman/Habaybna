<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_users', function (Blueprint $table) {
            $table->increments('id');
            $table-> unsignedInteger('user_id');
            $table->text('firstName');
            $table->text('lastName');
            $table->enum('gender', ['m', 'f']);
            $table->timestamp('dob');
            $table->string('avatar')->default('default.jpg');
            $table->boolean('status')->default(true);
            $table->rememberToken();
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
        Schema::dropIfExists('parent_users');
    }
}

