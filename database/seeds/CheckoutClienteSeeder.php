<?php

use Illuminate\Database\Seeder;

class CheckoutClienteSeeder extends Seeder
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
                Segue o link do checkout para finalizar seu pedido,<br>
                <br><br>Acesse:  <a href="__url__">checkout</a><br>',
            'tipo'              => 'Envio de Checkout',
            'assunto'           => 'Checkout MedSafer',
        ]);
    }
}
