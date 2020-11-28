<?php

use Illuminate\Database\Seeder;

class CadastroClienteSeeder extends Seeder
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
            'conteudo'          => 'Olá, __nome__! <br> 
                Segue os dados para o seu acesso ao Meu MedSafer,<br>
                <br><br>Acesse o sistema com o e-mail: __email__ <br>
                Senha: __senha__',
            'tipo'              => 'Cadastro de Cliente',
            'assunto'           => 'Primeiro Acesso',
        ]);
    }
}
