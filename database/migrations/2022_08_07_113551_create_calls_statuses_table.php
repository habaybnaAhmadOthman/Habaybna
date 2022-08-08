<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallsStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calls_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')
            ->constrained('calls_appointments')
            ->onDelete('cascade');
            $table->enum('status', [0, 1, 2, 3]); // 0=> booked not happend yet , 1=> booked and happend , 2=>booked and not happend almost
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
        Schema::dropIfExists('calls_statuses');
    }
}
