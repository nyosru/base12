<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopPayNsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_pay_ns', function (Blueprint $table) {
            $table->id();

            $table->string('vypal')->nullable();
            $table->string('nomer-sceta')->nullable();
            $table->string('naimenovanie')->nullable();
            $table->string('firma')->nullable();
            $table->string('debet-na-naclo-perioda')->nullable();
            $table->string('kredit-na-naclo-perioda')->nullable();
            $table->string('oborot-debet')->nullable();
            $table->string('oborot-kredit')->nullable();
            $table->string('debet-na-konec-perioda')->nullable();
            $table->string('kredit-na-konec-perioda')->nullable();

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
        Schema::dropIfExists('shop_pay_ns');
    }
}
