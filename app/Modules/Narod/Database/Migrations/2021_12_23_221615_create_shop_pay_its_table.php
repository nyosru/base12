<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopPayItsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_pay_its', function (Blueprint $table) {
            $table->id();

            $table->string('firma')->nullable();
            $table->string('paishhik')->nullable();
            $table->string('paishhikkod')->nullable();
            $table->string('paishhiksocset')->nullable();
            $table->string('debet')->nullable();
            $table->string('kredit')->nullable();
            $table->string('status')->nullable();
            $table->string('telefon')->nullable();

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
        Schema::dropIfExists('shop_pay_its');
    }
}
