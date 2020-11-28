<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContaTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conta_transactions', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('conta_bancaria_id')->unsigned()->nullable();
            $table->foreign('conta_bancaria_id')->references('id')->on('contas_bancarias');
            $table->double('valor', 15, 2);
            $table->string('hash', 60);
            $table->string('tipo', 30);
            $table->boolean('accepted')->default(true);
            $table->json('meta')->nullable();
            //$table->foreign('conta_bancaria_id')->references('id')->on('contas_bancarias')->onDelete('cascade');

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
        Schema::dropIfExists('conta_transactions');
    }
}
