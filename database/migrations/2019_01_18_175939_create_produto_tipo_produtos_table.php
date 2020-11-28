<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutoTipoProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produto_tipo_produtos', function (Blueprint $table) {
            $table->increments('id');
            $table->double('valor', 15, 2);
            $table->integer('qtd_parcela');
            $table->double('valor_parcela', 15, 2);
            $table->integer('produto_id')->unsigned()->nullable();
            $table->foreign('produto_id')->references('id')->on('produtos');
            $table->integer('tipo_produto_id')->unsigned()->nullable();
            $table->foreign('tipo_produto_id')->references('id')->on('tipo_produtos');
            $table->integer('categoria_produto_id')->unsigned()->nullable();
            $table->foreign('categoria_produto_id')->references('id')->on('categoria_produtos');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produto_tipo_produtos');
    }
}
