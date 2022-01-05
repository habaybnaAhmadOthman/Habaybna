<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->enum('usage',['course','call']); // where to apply code
            $table->enum('type',['free','discount']); // type of discount free access or discount percentage
            $table->boolean('status')->default(0); // active deactive the code usage
            $table->unsignedInteger('max_usage')->default(0); // Most attempts using the code
            $table->unsignedInteger('usage_count')->default(0)->nullable(); // current usage attempts
            $table->float('discount_percentage')->nullable(); // amount of discount value
            $table->timestamp('expiry_date')->nullable(); // when the code to be not valid (date)
            $table->string('created_by')->nullable();  // the admin who create the code
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
        Schema::dropIfExists('promo_codes');
    }
}
