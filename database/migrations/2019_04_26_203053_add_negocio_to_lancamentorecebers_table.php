<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNegocioToLancamentorecebersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lancamentos_receber', function (Blueprint $table) {
            //
            $table->integer('negocio_id')->unsigned()->nullable();
            $table->foreign('negocio_id')->references('id')->on('negocios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lancamentos_receber', function (Blueprint $table) {
            //
            $table->dropColumn('negocio_id');
        });
    }
}
