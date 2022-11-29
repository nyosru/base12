<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phpcat-tests', function (Blueprint $table) {
            $table->id();
            $table->string('head');
            $table->date('date');

            $table->text('text')->nullable();
            $table->text('code')->nullable();

            $table->string('link1');
            $table->string('link2');
            $table->string('link3');

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phpcat-tests');
    }
}
