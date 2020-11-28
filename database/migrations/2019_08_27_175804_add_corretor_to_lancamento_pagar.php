<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCorretorToLancamentoPagar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lancamentos_pagar', function (Blueprint $table) {
            $table->integer('corretor_id')->unsigned()->nullable();
            $table->foreign('corretor_id')->references('id')->on('corretores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lancamentos_pagar', function (Blueprint $table) {
            $table->dropColumn('corretor_id');
        });
    }
}
