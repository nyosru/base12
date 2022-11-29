<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('pages', function (Blueprint $table) {
        //     $table->id();

        //     $table->string('module', 200)
        //         ->comment('модуль страницы');
        //     $table->string('level', 200)
        //         ->comment('тех название страницы');
        //     $table->string('name', 200)
        //         ->comment('название страницы');
        //     $table->string('description', 200)
        //         ->comment('крастко еописание до 200сим');
        //     $table->text('html')
        //         ->comment('текст страницы');

        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('pages');
    }
}
