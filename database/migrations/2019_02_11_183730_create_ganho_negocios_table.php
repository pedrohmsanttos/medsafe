<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGanhoNegociosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ganho_negocios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('comentario')->nullable();
            $table->integer('negocio_id')->unsigned()->nullable();
            $table->foreign('negocio_id')->references('id')->on('negocios');
            $table->integer('usuario_operacao_id')->unsigned()->nullable();
            $table->foreign('usuario_operacao_id')->references('id')->on('users');
            $table->date('data_ganho');
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
        Schema::dropIfExists('ganho_negocios');
    }
}
