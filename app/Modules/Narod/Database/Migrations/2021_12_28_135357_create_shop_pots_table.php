<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopPotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_pots', function (Blueprint $table) {
            $table->id();

            $table->string('naimenovanie')->nullable();
            $table->string('dobavka')->nullable();
            $table->string('mol')->nullable();
            $table->string('sait')->nullable();
            $table->string('yashhik')->nullable();
            $table->string('edizm')->nullable();
            $table->string('kodt')->nullable();
            $table->string('kolicestvo')->nullable();

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
        Schema::dropIfExists('shop_pots');
    }
}
