<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToCorretor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('corretores', function (Blueprint $table) {
            $table->integer('aprovado')->default(0)->nullable();
            $table->double('comissao', 15, 2)->nullable();
            $table->string('periodo_de_pagamento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('corretores', function (Blueprint $table) {
            $table->dropColumn('aprovado');
            $table->dropColumn('comissao');
            $table->dropColumn('periodo_de_pagamento');
        });
    }
}
