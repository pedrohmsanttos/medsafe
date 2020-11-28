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
            $table->integer('is_seguro_terceiro')->default(0)->nullable();
            $table->string('nome_seguro_terceiro')->default('')->nullable();
            $table->string('cpf_seguro_terceiro')->default('')->nullable();
            $table->string('telefone_seguro_terceiro')->default('')->nullable();
            $table->string('email_seguro_terceiro')->default('')->nullable();
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
            $table->dropColumn('is_seguro_terceiro');
            $table->dropColumn('nome_seguro_terceiro');
            $table->dropColumn('cpf_seguro_terceiro');
            $table->dropColumn('telefone_seguro_terceiro');
            $table->dropColumn('email_seguro_terceiro');
        });
    }
}
