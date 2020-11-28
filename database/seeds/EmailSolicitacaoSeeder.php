<?php

use Illuminate\Database\Seeder;

class EmailSolicitacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Criação do
        DB::table('mails')->insert([
            'conteudo'          => 'Olá, __nome__! <br> Ha uma nova interação em sua solicitação Nº __num_solicitacao__',
            'tipo'              => 'Solicitação',
            'assunto'           => 'Solicitação de Atendimento',
        ]);
    }
}
