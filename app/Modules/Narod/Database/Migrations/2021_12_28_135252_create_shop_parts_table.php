<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_parts', function (Blueprint $table) {
            $table->id();

            $table->string('proekt')->nullable();
            $table->string('pasport')->nullable();
            $table->string('proektkom')->nullable();
            $table->string('paspkom')->nullable();
            $table->string('proektkod')->nullable();
            $table->string('paspkod')->nullable();

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
        Schema::dropIfExists('shop_parts');
    }
}
