<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNegociosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('negocios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
            $table->double('valor', 15, 2);
            $table->date('data_fechamento');
            $table->date('data_criacao');
            $table->string('etapa', 2);
            $table->string('status', 2);
            $table->date('data_perda');
            $table->date('data_ganho');
            $table->mediumText('motivo_perda');
            $table->integer('organizacao_id')->unsigned()->nullable();
            $table->foreign('organizacao_id')->references('id')->on('organizacaos');
            $table->integer('pessoa_id')->unsigned()->nullable();
            $table->foreign('pessoa_id')->references('id')->on('pessoas');
            $table->integer('motivo_perda_negocio_id')->unsigned()->nullable();
            $table->foreign('motivo_perda_negocio_id')->references('id')->on('motivo_perda_negocio');

            $table->softDeletes();
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
        Schema::dropIfExists('negocios');
    }
}
