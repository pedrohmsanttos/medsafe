<?php

namespace App\Listeners;

use App\Events\BaixaLancamentoReceber;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;

class EntradaContaBancaria
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
     * @param  BaixaLancamentoReceber  $event
     * @return void
     */
    public function handle(BaixaLancamentoReceber $event)
    {
        $baixa = $event->baixaReceber();
        $arrLog = json_encode(array_merge($baixa->toArray(), ['user_id'=>Auth::user()->id, 'titulo'=> $baixa->lancamentosReceber->cliente->nomeFantasia, 'cliente_id' => $baixa->lancamentosReceber->cliente->id], ['plano_de_contas_id'=>$baixa->plano_de_conta_id, 'origem'=>'baixa_receber']));
        $baixa->contasBancaria->deposito($baixa->valor_pago, 'deposito', $arrLog);
    }
}
