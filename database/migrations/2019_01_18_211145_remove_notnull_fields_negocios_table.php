<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveNotnullFieldsNegociosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('negocios', function (Blueprint $table) {
            $table->string('data_fechamento')->nullable()->change();
            $table->string('data_criacao')->nullable()->change();
            $table->string('etapa')->nullable()->change();
            $table->string('data_perda')->nullable()->change();
            $table->string('data_ganho')->nullable()->change();
            $table->string('motivo_perda')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('negocios', function (Blueprint $table) {
            $table->string('data_fechamento')->change();
            $table->string('data_criacao')->change();
            $table->string('etapa')->change();
            $table->string('data_perda')->change();
            $table->string('data_ganho')->change();
            $table->string('motivo_perda')->change();
        });
    }
}
