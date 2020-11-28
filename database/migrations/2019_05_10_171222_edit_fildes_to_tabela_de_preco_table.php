<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditFildesToTabelaDePrecoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produto_tipo_produtos', function (Blueprint $table) {
            $table->dropColumn('valor_parcela');
        });
        Schema::table('produto_tipo_produtos', function (Blueprint $table) {
            $table->dropColumn('qtd_parcela');
        });
        Schema::table('produto_tipo_produtos', function (Blueprint $table) {
            $table->string('fonte')->nullable()->default('MedSafer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produto_tipo_produtos', function (Blueprint $table) {
            //
            $table->dropColumn('fonte');
        });
    }
}
