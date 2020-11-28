<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeguradoraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // $this->down();
        Schema::create('seguradoras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricaoCorretor', 255);
            $table->string('CNPJ', 14);
            $table->string('telefone', 12);
            $table->string('email', 50);
            
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
        Schema::dropIfExists('seguradora');
        Schema::dropIfExists('seguradoras');
    }
}
