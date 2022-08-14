<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentChildInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_child_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('appointment_id');
            $table->string('discovered_age')->nullable();
            $table->string('age')->nullable();
            $table->string('child_situation')->nullable();
            $table->string('child_status')->nullable();
            $table->text('message')->nullable();
            $table->text('recommendation')->nullable();
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
        Schema::dropIfExists('appointment_child_infos');
    }
}
