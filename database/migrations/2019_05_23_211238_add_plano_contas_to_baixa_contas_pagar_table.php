<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlanoContasToBaixaContasPagarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('baixa_contas_pagar', function (Blueprint $table) {
            //
            $table->integer('plano_de_conta_id')->unsigned()->nullable();
            $table->foreign('plano_de_conta_id')->references('id')->on('plano_de_contas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('baixa_contas_pagar', function (Blueprint $table) {
            //
            $table->dropColumn('plano_de_conta_id');
        });
    }
}
