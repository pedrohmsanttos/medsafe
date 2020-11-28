<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizacaoEnderecosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('organizacao_enderecos', function (Blueprint $table) {
            $table->integer('organizacao_id')->unsigned()->nullable();
            $table->foreign('organizacao_id')->references('id')->on('organizacaos');
            $table->integer('endereco_id')->unsigned()->nullable();
            $table->foreign('endereco_id')->references('id')->on('enderecos');
            $table->softDeletes();
            $table->timestamps();
            $table->primary(array('organizacao_id', 'endereco_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizacao_enderecos');
    }
}
