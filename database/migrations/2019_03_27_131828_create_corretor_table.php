<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorretorTable extends Migration
{
    /**
     * Run the migrations.
     * ID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
     * CORRETORA_ID INTEGER UNSIGNED NOT NULL,
     * CORRETOR_NOME VARCHAR(255) NULL,
     * CORRETOR_CPF VARCHAR(11) NULL,
     * CORRETOR_TELEFONE VARCHAR(12) NULL,
     * CORRETOR_EMAIL VARCHAR(50) NULL,
     * CORRETOR_CELULAR VARCHAR(12) NULL,
     * @return void
     */
    public function up()
    {
        Schema::create('corretores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 255)->nullable();
            $table->string('cpf', 11)->nullable();
            $table->string('telefone', 12)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('celular', 12)->nullable();
            $table->integer('corretora_id')->unsigned();
            $table->foreign('corretora_id')->references('id')->on('corretoras');
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
        Schema::dropIfExists('corretores');
    }
}
