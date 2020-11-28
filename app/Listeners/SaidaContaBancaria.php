<?php

namespace App\Listeners;

use App\Events\BaixaLancamentoPagar;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\BaixaPagar;
use Auth;

class SaidaContaBancaria
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
     * @param  BaixaLancamentoPagar  $event
     * @return void
     */
    public function handle(BaixaLancamentoPagar $event)
    {
        $baixa  = $event->baixaPagar();
        $arrLog = json_encode(array_merge($baixa->toArray(), ['user_id'=>Auth::user()->id, 'titulo'=> $baixa->lancamentosPagar->fornecedor->nomeFantasia, 'fornecedor_id' => $baixa->lancamentosPagar->fornecedor->id], ['plano_de_contas_id'=>$baixa->plano_de_conta_id, 'origem'=>'baixa_pagar']));
        $baixa->contasBancaria->retirada($baixa->valor_pago, 'retirada', $arrLog);
    }
}
