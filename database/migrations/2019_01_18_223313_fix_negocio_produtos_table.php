<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixNegocioProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('negocio_produtos', function (Blueprint $table) {
            $table->integer('negocio_id')->unsigned()->nullable();
            $table->foreign('negocio_id')->references('id')->on('negocios');
            $table->integer('produto_tipo_produto_id')->unsigned()->nullable();
            $table->foreign('produto_tipo_produto_id')->references('id')->on('produto_tipo_produtos');
            $table->softDeletes();
            $table->timestamps();
            $table->primary(array('negocio_id', 'produto_tipo_produto_id'));            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('negocio_produtos');
    }
}
