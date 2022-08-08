<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallPurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('specialist_id');
            $table->unsignedInteger('appointment_id');
            $table->string('transaction_id')->nullable();
            $table->unsignedInteger('price')->nullable();
            $table->boolean('status')->nullable()->default(0);
            $table->string('status_description')->nullable();
            $table->string('card_holder_name')->nullable();
            $table->string('card_number')->nullable();
            $table->string('card_expiry_date')->nullable();
            $table->unsignedInteger('coupon_id')->nullable();
            $table->unsignedInteger('discount_amount')->nullable();
            $table->unsignedInteger('amount')->nullable();
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
        Schema::dropIfExists('call_purchase_orders');
    }
}
