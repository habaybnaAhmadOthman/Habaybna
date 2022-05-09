<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterParentUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parent_users', function (Blueprint $table) {
            $table->string('childs_count')->nullable();
            $table->string('speci_childs_count')->nullable();
            $table->text('edu_level')->nullable();
            $table->text('city')->nullable();
            $table->text('employment')->nullable();
            $table->text('job_title')->nullable();
            $table->text('why_to_join')->nullable();
            $table->boolean('private_mode')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parent_users', function (Blueprint $table) {
            //
        });
    }
}
