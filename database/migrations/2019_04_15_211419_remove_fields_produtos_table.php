<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFieldsProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('produtos', 'valor')) {
            Schema::table('produtos', function (Blueprint $table) {
                $table->dropColumn('valor');
            });
        }

        if (Schema::hasColumn('produtos', 'tipo_produto_id')) {
            Schema::table('produtos', function (Blueprint $table) {
                $table->dropForeign('tipo_produto_id');
            });
            Schema::table('produtos', function (Blueprint $table) {
                $table->dropColumn('tipo_produto_id');
            });
        }

        if (Schema::hasColumn('produtos', 'categoria_produto_id')) {
            Schema::table('produtos', function (Blueprint $table) {
                $table->dropForeign('categoria_produto_id');
            });
            Schema::table('produtos', function (Blueprint $table) {
                $table->dropColumn('categoria_produto_id');
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
    }
}
