<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAffRegApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aff_reg_application', function (Blueprint $table) {
            $table->foreign(['aff_profile_id'])->references('id')->on('aff_profile')
                ->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aff_reg_application', function (Blueprint $table) {
            $table->dropForeign(['aff_profile_id']);
        });
    }
}
