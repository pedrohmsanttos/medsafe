<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMotivoToPerdaNegociosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('perda_negocios', function (Blueprint $table) {
            //
            $table->integer('motivo_perda_id')->unsigned()->nullable();
            $table->foreign('motivo_perda_id')->references('id')->on('motivo_perda_negocio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('perda_negocios', function (Blueprint $table) {
            $table->dropForeign(['motivo_perda_id']);
        });
        Schema::table('perda_negocios', function (Blueprint $table) {
            $table->dropColumn('motivo_perda_id');
        });
    }
}
