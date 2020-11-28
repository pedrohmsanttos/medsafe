<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContasBancariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // $this->down();
        Schema::create('contas_bancarias', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('classificacao', 18);
            $table->string('descricao', 50);
            $table->string('numeroConta', 20)->nullable();
            $table->string('numeroAgencia', 255)->nullable();
            $table->date('dataSaldoInicial');
            $table->double('saldoInicial', 15, 2);
            $table->string('caixa', 10);
            $table->string('banco', 10);
            
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
        Schema::dropIfExists('contas_bancarias');
    }
}
