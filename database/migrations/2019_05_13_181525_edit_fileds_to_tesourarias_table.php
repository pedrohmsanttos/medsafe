<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditFiledsToTesourariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tesourarias', function (Blueprint $table) {
            //
            $table->string('numero_documento', 20)->nullable()->change();
            $table->date('data_emissao')->nullable()->change();
            $table->date('data_vencimento')->nullable()->change();
            $table->date('data_disponibilidade')->nullable()->change();
            $table->integer('contas_bancaria_id')->unsigned()->nullable();
            $table->foreign('contas_bancaria_id')->references('id')->on('contas_bancarias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tesourarias', function (Blueprint $table) {
            //
        });
    }
}
