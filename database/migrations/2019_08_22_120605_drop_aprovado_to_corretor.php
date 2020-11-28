<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAprovadoToCorretor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('corretores', function (Blueprint $table) {
            $table->dropColumn('aprovado');
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
            $table->integer('aprovado')->default(0)->nullable();
        });
    }
}
