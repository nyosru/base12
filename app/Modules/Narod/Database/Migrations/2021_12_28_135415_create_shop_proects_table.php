<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopProectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_proects', function (Blueprint $table) {
            $table->id();

            $table->string('j1-uon-firma')->nullable();
            $table->string('j2-uon-proekt')->nullable();
            $table->string('j3-uon-scet')->nullable();
            $table->string('j4-uon-paishhik')->nullable();
            $table->string('komentarii')->nullable();
            $table->string('debetnac')->nullable();
            $table->string('debetnackol')->nullable();
            $table->string('kreditnac')->nullable();
            $table->string('kreditnackol')->nullable();
            $table->string('debet')->nullable();
            $table->string('debetkol')->nullable();
            $table->string('kredit')->nullable();
            $table->string('kreditkol')->nullable();
            $table->string('debetkon')->nullable();
            $table->string('debetkonkol')->nullable();
            $table->string('kreditkon')->nullable();
            $table->string('kreditkonkol')->nullable();
            $table->string('sait')->nullable();
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
        Schema::dropIfExists('shop_proects');
    }
}
