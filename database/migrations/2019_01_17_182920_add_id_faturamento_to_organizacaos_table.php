<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdFaturamentoToOrganizacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizacaos', function (Blueprint $table) {
            $table->integer('faturamento_id')->unsigned()->nullable();
            $table->foreign('faturamento_id')->references('id')->on('faturamentos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizacaos', function (Blueprint $table) {
            //$table->dropColumn(['faturamento_id']);
        });
    }
}
