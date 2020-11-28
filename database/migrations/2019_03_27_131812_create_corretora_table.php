<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorretoraTable extends Migration
{
    /**
     * Run the migrations.
     *  ID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
     * CORRETOR_DESCRICAO VARCHAR(255) NULL,
     * CORRETORA_CNPJ VARCHAR(14) NULL,
     * CORRETORA_TELEFONE VARCHAR(12) NULL,
     * CORRETORA_EMAIL VARCHAR(50) NULL,
     * CORRETORA_REGISTROSUSEP VARCHAR(50) NULL,
     * @return void
     */
    public function up()
    {
        Schema::create('corretoras', function (Blueprint $table) {
            $table->increments('id');
            $table->softDeletes();
            $table->string('descricao', 255)->nullable();
            $table->string('cnpj', 14)->nullable();
            $table->string('telefone', 12)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('susep', 50)->nullable();
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
        Schema::dropIfExists('corretoras');
    }
}
