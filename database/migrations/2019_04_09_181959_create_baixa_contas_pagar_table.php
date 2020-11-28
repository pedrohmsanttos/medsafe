<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaixaContasPagarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baixa_contas_pagar', function (Blueprint $table) {
            $table->increments('id');
            $table->date('disponibilidade');
            $table->date('baixa');
            $table->double('valor_pago', 15, 2)->nullable();
            $table->double('valor_residual', 15, 2)->nullable();
            $table->integer('conta_bancaria_id')->unsigned()->nullable();
            $table->foreign('conta_bancaria_id')->references('id')->on('contas_bancarias');
            $table->integer('pagamento_id')->unsigned()->nullable();
            $table->foreign('pagamento_id')->references('id')->on('formas_de_pagamento');
            $table->integer('lancamentopagar_id')->unsigned()->nullable();
            $table->foreign('lancamentopagar_id')->references('id')->on('lancamentos_pagar');
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
        Schema::dropIfExists('baixa_contas_pagar');
    }
}
