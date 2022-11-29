<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopOstsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_osts', function (Blueprint $table) {
            $table->id();

            $table->string('naimenovanie')->nullable();
            $table->string('dobavka')->nullable();
            $table->string('organizaciya')->nullable();
            $table->string('sait')->nullable();
            $table->string('saitsdelal')->nullable();
            $table->string('edizm')->nullable();
            $table->string('srokgod')->nullable();
            $table->string('kodt')->nullable();
            $table->string('kolicestvo')->nullable();
            $table->string('zakaz')->nullable();
            $table->string('upakovok')->nullable();
            $table->string('upakovkazakaz')->nullable();
            $table->string('cena1')->nullable();
            $table->string('cena2')->nullable();
            $table->string('cena3')->nullable();

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
        Schema::dropIfExists('shop_osts');
    }
}
