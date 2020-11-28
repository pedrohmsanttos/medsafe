<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToPedidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('beneficio_terceiros')->default(0)->nullable();
            $table->string('nome_completo')->default('')->nullable();
            $table->string('telefone')->default('')->nullable();
            $table->string('cpf')->default('')->nullable();
            $table->string('email')->default('')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pedidos', function (Blueprint $table) {

            $table->dropColumn('beneficio_terceiros');
            $table->dropColumn('nome_completo');
            $table->dropColumn('telefone');
            $table->dropColumn('cpf');
            $table->dropColumn('email');
        });
    }
}
