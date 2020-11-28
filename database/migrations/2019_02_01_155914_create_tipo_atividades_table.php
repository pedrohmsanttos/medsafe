<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoAtividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_atividades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('tipo_atividades')->insert(
            array('descricao'     => "Ligação")
        );
        DB::table('tipo_atividades')->insert(
            array('descricao'     => "Reunião")
        );
        DB::table('tipo_atividades')->insert(
            array('descricao'     => "Visita")
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_atividades');
    }
}
