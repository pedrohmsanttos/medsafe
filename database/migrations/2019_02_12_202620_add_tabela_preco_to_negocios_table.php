<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTabelaPrecoToNegociosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('negocios', function (Blueprint $table) {
            $table->integer('tabela_preco_id')->unsigned()->nullable();
            $table->foreign('tabela_preco_id')->references('id')->on('produto_tipo_produtos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('negocios', 'tabela_preco_id')) {
            Schema::table('negocios', function (Blueprint $table) {
                $table->dropForeign('tabela_preco_id');
            });
            Schema::table('negocios', function (Blueprint $table) {
                $table->dropColumn('tabela_preco_id');
            });
        }
    }
}
