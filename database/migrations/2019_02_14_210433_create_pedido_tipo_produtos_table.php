<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidoTipoProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_tipo_produtos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pedido_id')->unsigned()->nullable();
            $table->foreign('pedido_id')->references('id')->on('pedidos');
            $table->integer('categoria_produto_id')->unsigned()->nullable();
            $table->foreign('categoria_produto_id')->references('id')->on('categoria_produtos');
            $table->integer('tipo_produto_id')->unsigned()->nullable();
            $table->foreign('tipo_produto_id')->references('id')->on('tipo_produtos');
            $table->integer('produto_id')->unsigned()->nullable();
            $table->foreign('produto_id')->references('id')->on('produtos');
            $table->double('valor', 15, 2)->nullable();
            $table->double('valor_parcela', 15, 2)->nullable();
            $table->double('valor_desconto', 15, 2)->nullable();
            $table->double('valor_final', 15, 2)->nullable();
            $table->integer('quantidade_parcela')->nullable();
            $table->integer('quantidade')->nullable();
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
        Schema::dropIfExists('pedido_tipo_produtos');
    }
}
