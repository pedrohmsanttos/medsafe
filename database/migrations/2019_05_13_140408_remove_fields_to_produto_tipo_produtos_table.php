<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFieldsToProdutoTipoProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('produtos', 'qtd_parcela')) {
            Schema::table('produto_tipo_produtos', function (Blueprint $table) {
                $table->dropColumn('qtd_parcela');
            });
        }
        if (Schema::hasColumn('produtos', 'valor_parcela')) {
            Schema::table('produto_tipo_produtos', function (Blueprint $table) {
                $table->dropColumn('valor_parcela');
            });
        }
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
