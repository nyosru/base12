<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopKontrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_kontrs', function (Blueprint $table) {
            $table->id();
            $table->string('organizaciya')
                ->nullable();
            $table->string('mol')
                ->nullable();
            $table->string('kodorg')
                ->nullable();
            $table->string('kodmol')
                ->nullable();
            $table->string('saitmol')
                ->nullable();
            $table->string('dogovor')
                ->nullable();
            $table->string('dognom')
                ->nullable();
            $table->string('tiporg')
                ->nullable();
            $table->string('polnnaim')
                ->nullable();
            $table->string('yuradres')
                ->nullable();
            $table->string('inn')
                ->nullable();
            $table->string('kodorganizacii')
                ->nullable();
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
        Schema::dropIfExists('shop_kontrs');
    }
}
