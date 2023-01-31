<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialistZoomAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialist_zoom_account', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('spec_id')->nullable();
            $table->string('zoom_link')->nullable();
            $table->string('meeting_id')->nullable();
            $table->boolean('status')->nullable();
            $table->string('password')->nullable();
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
        Schema::dropIfExists('specialist_zoom_account');
    }
}
