<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopFirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_firs', function (Blueprint $table) {
            $table->id();

            $table->string('organizaciya')->nullable();
            $table->string('kodorganizacii')->nullable();
            $table->string('banksceta')->nullable();
            $table->string('kodbanksceta')->nullable();
            $table->string('polnnaim')->nullable();
            $table->string('inn')->nullable();
            $table->string('kpp')->nullable();
            $table->string('yuradres')->nullable();
            $table->string('bankscet')->nullable();
            $table->string('bankrasc')->nullable();
            $table->string('adresbankarasc')->nullable();
            $table->string('korrscetbankarasc')->nullable();
            $table->string('telefon')->nullable();
            $table->string('bikbankarasc')->nullable();
            $table->string('pecatka')->nullable();

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
        Schema::dropIfExists('shop_firs');
    }
}
