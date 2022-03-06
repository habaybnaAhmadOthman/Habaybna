<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursespurchaseordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses_purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id'); //
            $table->unsignedInteger('course_id'); //
            $table->string('transactionID')->nullable();
            $table->unsignedInteger('price'); //
            $table->boolean('status')->nullable(); //
            $table->string('status_description')->nullable();
            $table->text('card_holder_name')->nullable();
            $table->string('card_number')->nullable();
            $table->string('card_expiry_date')->nullable();
            $table->unsignedInteger('coupon_id')->nullable(); //
            $table->unsignedInteger('discount_amount')->nullable(); //
            $table->unsignedInteger('new_price')->nullable(); //
            $table->string('amount')->nullable(); //
            $table->string('approval_code')->nullable();
            $table->text('secure_hash')->nullable();
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
        Schema::dropIfExists('coursespurchaseorders');
    }
}
