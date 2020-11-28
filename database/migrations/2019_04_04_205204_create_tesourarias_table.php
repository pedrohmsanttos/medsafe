<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTesourariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tesourarias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plano_de_contas_id')->unsigned()->nullable();
            $table->foreign('plano_de_contas_id')->references('id')->on('plano_de_contas');
            $table->integer('formas_de_pagamento_id')->unsigned()->nullable();
            $table->foreign('formas_de_pagamento_id')->references('id')->on('formas_de_pagamento');
            $table->integer('fornecedor_id')->unsigned()->nullable();
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores');
            $table->integer('cliente_id')->unsigned()->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->char('tipo', 1)->default('0'); //1 - Cliente | 2- Fornecedor
            $table->string('valor');
            $table->string('numero_documento', 20);
            $table->date('data_emissao');
            $table->date('data_vencimento');
            $table->date('data_disponibilidade');
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
        Schema::dropIfExists('tesourarias');
    }
}
