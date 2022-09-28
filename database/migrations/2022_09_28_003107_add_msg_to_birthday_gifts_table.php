<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMsgToBirthdayGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('birthday_gifts', function (Blueprint $table) {
           $table->boolean('show_in_list')->default(0)->after('amount');
           $table->text('msg')->nullable()->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('birthday_gifts', function (Blueprint $table) {
            //
        });
    }
}
