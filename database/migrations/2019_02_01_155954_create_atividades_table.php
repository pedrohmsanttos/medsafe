<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atividades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('negocio_id')->unsigned()->nullable();
            $table->foreign('negocio_id')->references('id')->on('negocios');
            $table->string('assunto', 255);
            $table->date('data');
            $table->time('hora');
            $table->time('duracao')->nullable();
            $table->text('notas')->nullable();
            $table->string('urlProposta', 255)->nullable();
            $table->integer('tipo_atividade_id')->unsigned()->nullable();
            $table->foreign('tipo_atividade_id')->references('id')->on('tipo_atividades');
            $table->char('realizada',1)->default('0');
            $table->date('dataVencimento')->nullable();
            $table->integer('criador_id')->unsigned()->nullable();
            $table->foreign('criador_id')->references('id')->on('users');
            $table->integer('atribuido_id')->unsigned()->nullable();
            $table->foreign('atribuido_id')->references('id')->on('users');
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
        Schema::dropIfExists('atividades');
    }
}
