<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->integer('id', true)->unsigned();
            $table->foreignId('user_id')->notNullable()->index();
            $table->text('titulo')->notNullable();
            $table->longText('descricao')->nullable();
            $table->date('datadoc')->notNullable();
            $table->string('nomearq')->nullable();
            $table->integer('docsize')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentos');
    }
};
