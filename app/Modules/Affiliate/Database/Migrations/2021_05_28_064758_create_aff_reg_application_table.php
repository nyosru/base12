<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffRegApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aff_reg_application', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aff_profile_id')->nullable();
            $table->string('text');
            $table->unsignedTinyInteger('status')->default(0);
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aff_reg_application');
    }
}
