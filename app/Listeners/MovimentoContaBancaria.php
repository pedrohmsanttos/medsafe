<?php

namespace App\Listeners;

use App\Events\EntradaTesouraria;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;

class MovimentoContaBancaria
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EntradaTesouraria  $event
     * @return void
     */
    public function handle(EntradaTesouraria $event)
    {
        $movimento = $event->tesouraria();
        
        if (isset($movimento->cliente_id)) {
            $arrLog = json_encode(array_merge($movimento->toArray(), ['user_id'=>Auth::user()->id, 'origem'=>'tesouraria', 'titulo'=> $movimento->cliente->nomeFantasia]));
            $movimento->contasBancaria->deposito($movimento->valor, 'deposito', $arrLog);
        } else {
            $arrLog = json_encode(array_merge($movimento->toArray(), ['user_id'=>Auth::user()->id, 'origem'=>'tesouraria', 'titulo'=> $movimento->fornecedor->nomeFantasia]));
            $movimento->contasBancaria->retirada($movimento->valor, 'retirada', $arrLog);
        }
    }
}
