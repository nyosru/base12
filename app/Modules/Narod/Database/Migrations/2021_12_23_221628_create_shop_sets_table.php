<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_sets', function (Blueprint $table) {
            $table->id();

            $table->string('data')->nullable();
            $table->date('data_ru')->nullable();
            $table->string('firma')->nullable();
            $table->string('znaceniedok')->nullable();
            $table->string('nomerdokp')->nullable();
            $table->string('datadokp')->nullable();
            $table->date('datadokp_ru')->nullable();
            $table->string('organizaciya')->nullable();
            $table->string('mol')->nullable();
            $table->string('proekt')->nullable();
            $table->string('pasport')->nullable();
            $table->string('komentarii')->nullable();
            $table->string('naimenovanie')->nullable();
            $table->string('dobavka')->nullable();
            $table->string('edizm')->nullable();
            $table->string('kodt')->nullable();
            $table->string('kolicestvo')->nullable();
            $table->string('upakovok')->nullable();
            $table->string('cena')->nullable();
            $table->string('summa')->nullable();
            $table->string('foto')->nullable();

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
        Schema::dropIfExists('shop_sets');
    }
}
