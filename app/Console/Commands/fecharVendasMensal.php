<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Corretor;
use App\Models\Comissao;
use App\Models\Checkout;
use App\Models\Parametro;

class fecharVendasMensal extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fecharVendas:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fecha vendas e gera comissão';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(

    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $checkouts = Checkout::where('comissao_gerada','NAO')->get();
	\Log::info("Registros no banco".count($checkouts));
	foreach ($checkouts as $checkout) {
            if(isset($checkout->pedido()->first()->corretor_id)){
                $corretor = Corretor::find($checkout->pedido()->first()->corretor_id);
                $comissao =  new Comissao();
                $comissao->corretor_id = $checkout->pedido()->first()->corretor_id;
                $comissao->checkout_id = $checkout->id;
                $comissao->percentual_comissao = $corretor->comissao;
                $comissao->comissao = ($comissao->percentual_comissao / 100) * $checkout->valor;
                $comissao->valor = $checkout->valor;
                $comissao->save();
                $checkout->comissao_gerada = "SIM";
                $checkout->save();
            }
        }
    }
}
