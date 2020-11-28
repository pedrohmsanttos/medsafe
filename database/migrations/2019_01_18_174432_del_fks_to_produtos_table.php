<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DelFksToProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produtos', function (Blueprint $table) {
            // $table->dropForeign('categoria_produto_id');
            // $table->dropForeign('tipo_produto_id');

            // $table->dropColumn(['tipo_produto_id']);
            // $table->dropColumn(['categoria_produto_id']);
            // $table->dropColumn(['valor']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produtos', function (Blueprint $table) {
            // $table->double('valor', 15, 2);
            // $table->integer('tipo_produto_id')->unsigned()->nullable();
            // $table->foreign('tipo_produto_id')->references('id')->on('tipo_produtos');
            // $table->integer('categoria_produto_id')->unsigned()->nullable();
            // $table->foreign('categoria_produto_id')->references('id')->on('categoria_produtos');
        });
    }
}
