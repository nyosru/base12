<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();

            $table->string('site')
                ->comment('название сайта');
            $table->string('module')
                ->comment('модуль страницы');
            $table->string('name')
                ->nullable()
                ->comment('название страницы');
            $table->string('opis')
                ->nullable()
                ->comment('краткое описание');
            $table->text('html')
                ->nullable()
                ->comment('хтмл странички');

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
        Schema::dropIfExists('pages');
    }
}
