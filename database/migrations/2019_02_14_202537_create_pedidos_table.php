<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status_pedido_id')->unsigned()->nullable();
            $table->foreign('status_pedido_id')->references('id')->on('status_pedidos');
            $table->integer('cliente_id')->unsigned()->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->integer('corretor_id')->unsigned()->nullable();
            $table->foreign('usuario_operacao_id')->references('id')->on('users');
            $table->integer('usuario_operacao_id')->unsigned()->nullable();
            $table->date('data_vencimento');
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
        Schema::dropIfExists('pedidos');
    }
}
