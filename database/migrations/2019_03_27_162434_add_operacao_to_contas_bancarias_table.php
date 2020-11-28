<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOperacaoToContasBancariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contas_bancarias', function (Blueprint $table) {
            //$table->string('operacao')->nullable()->change();
            $table->string('operacao',10)->nullable();  
        });
    }

    /**
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contas_bancarias', function (Blueprint $table) {
            $table->dropColumn('operacao');
        });
    }
}
