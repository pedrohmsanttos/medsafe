<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaixaContasReceberTable extends Migration
{
    /**
     * Run the migrations.
     * FORMAPAGAMENTO_ID INTEGER UNSIGNED NOT NULL,
     * LANCAMENTOPAGAR_ID INTEGER UNSIGNED NOT NULL,
     * BAIXAPAGAR_CAIXABANCO CHAR(1) NULL,
     * BAIXAPAGAR_DISPONBILIDADE DATE NULL,
     * BAIXAPAGAR_DATABAIXA DATE NULL,
     * BAIXAPAGAR_VALORPAGO DECIMAL NULL,
     * BAIXAPAGAR_RESIDUAL DECIMAL NULL,
     * @return void
     */
    public function up()
    {
        Schema::create('baixa_contas_receber', function (Blueprint $table) {
            $table->increments('id');
            $table->string('caixa_banco', 1)->nullable();
            $table->date('disponibilidade');
            $table->date('baixa');
            $table->double('valor_pago', 15, 2)->nullable();
            $table->double('valor_residual', 15, 2)->nullable();
            $table->integer('pagamento_id')->unsigned()->nullable();
            $table->foreign('pagamento_id')->references('id')->on('formas_de_pagamento');
            $table->integer('lancamentoreceber_id')->unsigned()->nullable();
            $table->foreign('lancamentoreceber_id')->references('id')->on('lancamentos_receber');
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
        Schema::dropIfExists('baixa_contas_receber');
    }
}
