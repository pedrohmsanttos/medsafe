<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFornecedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // $this->down();
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->increments('id');

            $table->string('razaoSocial', 50);
            $table->string('nomeFantasia', 50);
            $table->string('classificacao', 18);
            $table->string('tipoPessoa', 2);
            $table->string('CNPJCPF', 15)->unique();
            $table->string('inscricaoEstadual', 20);
            $table->string('inscricaoMunicipal', 20);
            $table->string('telefone', 11);
            $table->string('email', 50);
            $table->string('nomeTitular', 50);
            $table->string('CPF', 11);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fornecedores');
    }
}
