<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPoleNacalod extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_pays', function (Blueprint $table) {
            $table->string('nacalod', 250);
            $table->string('nacalok', 250);
            $table->string('konecd', 250);
            $table->string('koneck', 250);
            $table->string('nacalodkol', 250);
            $table->string('debetkol', 250);
            $table->string('kreditkol', 250);
            $table->string('konecdkol', 250);
            $table->string('foto', 250);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_pays', function (Blueprint $table) {
            $table->dropColumn('nacalod');
            $table->dropColumn('nacalok');
            $table->dropColumn('konecd');

            $table->dropColumn('koneck');
            $table->dropColumn('nacalodkol');
            $table->dropColumn('debetkol');
            $table->dropColumn('kreditkol');
            $table->dropColumn('konecdkol');
            $table->dropColumn('foto');

        });
    }
}
