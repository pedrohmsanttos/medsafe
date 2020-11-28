<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveNotnullFieldsPlanoDeContasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plano_de_contas', function (Blueprint $table) {
            $table->string('caixa')->nullable()->change();
            $table->string('banco')->nullable()->change();
            $table->string('cliente')->nullable()->change();
            $table->string('fornecedor')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
