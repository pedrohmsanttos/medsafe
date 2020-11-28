<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFildsToClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            //
            $table->string('razaoSocial', 50)->nullable()->default('')->change();
            $table->string('classificacao', 18)->nullable()->default('')->change();
            $table->string('inscricaoEstadual', 20)->nullable()->default('')->change();
            $table->string('inscricaoMunicipal', 20)->nullable()->default('')->change();
            $table->string('nomeTitular', 50)->nullable()->default('')->change();
            $table->string('CPF', 11)->nullable()->default('')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            //
        });
    }
}
