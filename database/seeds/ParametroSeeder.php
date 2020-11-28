<?php

use Illuminate\Database\Seeder;

class ParametroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Criação do
        DB::table('parametros')->insert([
            'nome'          => 'apolices para renovação',
            'valor'              => '15'
        ]);
    }
}
