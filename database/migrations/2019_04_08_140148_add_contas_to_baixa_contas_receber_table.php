<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContasToBaixaContasReceberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('baixa_contas_receber', function (Blueprint $table) {
            //
            $table->integer('conta_bancaria_id')->unsigned()->nullable();
            $table->foreign('conta_bancaria_id')->references('id')->on('contas_bancarias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('baixa_contas_receber', function (Blueprint $table) {
            //
        });
    }
}
