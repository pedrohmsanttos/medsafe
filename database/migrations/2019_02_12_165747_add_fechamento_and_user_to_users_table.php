<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFechamentoAndUserToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('negocios', function (Blueprint $table) {
            //
            $table->date('data_vencimento')->nullable();
            $table->integer('usuario_operacao_id')->unsigned()->nullable();
            $table->foreign('usuario_operacao_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('negocios', 'data_vencimento')) {
            Schema::table('negocios', function (Blueprint $table) {
                $table->dropColumn('data_vencimento');
            });
        }
    }
}
