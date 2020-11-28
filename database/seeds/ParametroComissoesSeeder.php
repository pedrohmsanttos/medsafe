<?php

use Illuminate\Database\Seeder;

class ParametroComissoesSeeder extends Seeder
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
            'nome'          => 'Dia de pagamento das comissões da primeira quinzena',
            'valor'              => '05'
        ]);

        DB::table('parametros')->insert([
            'nome'          => 'Dia de pagamento das comissões da segunda quinzena',
            'valor'              => '05'
        ]);

        DB::table('parametros')->insert([
            'nome'          => 'Dia de pagamento das comissões mensais',
            'valor'              => '08'
        ]);
        DB::table('parametros')->insert([
            'nome'          => 'Prazo inicial para contagem de dias do vencimento das comissões',
            'valor'              => '10'
        ]);
    }
}
