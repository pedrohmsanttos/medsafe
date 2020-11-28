<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanoDeContasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // $this->down();
        Schema::create('plano_de_contas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('classificacao', 18);
            $table->string('descricao', 50);
            $table->string('tipoConta', 50);
            $table->string('caixa', 2);
            $table->string('banco', 2);
            $table->string('cliente', 2);
            $table->string('fornecedor', 2);
            $table->integer('contabancaria_id')->unsigned()->nullable();
            $table->foreign('contabancaria_id')->references('id')->on('contas_bancarias');

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
        Schema::dropIfExists('plano_de_contas');
    }
}
