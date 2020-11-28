<?php

use Illuminate\Database\Seeder;

class CadastroCorretorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Confirmação de Cadastro
        DB::table('mails')->insert([
            'conteudo'          => 'Olá! Que bom que você<br>chegou até aqui.<br><br>Olá, __nome__ <br>  Você está na etapa final para se tornar um Corretor MedSafer.<br>Agora, falta muito pouco.',
            'tipo'              => 'Cadastro de Corretor',
            'assunto'           => 'Boas-vindas',
        ]);
    }
}
