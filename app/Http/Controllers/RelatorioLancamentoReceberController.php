<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLancamentoReceberRequest;
use App\Http\Requests\UpdateLancamentoReceberRequest;
use App\Repositories\LancamentoReceberRepository;
use App\Repositories\ClienteRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use DateTime;

class RelatorioLancamentoReceberController extends Controller
{
    /** @var  lancamentoReceberRepository */
    private $lancamentoReceberRepository;
    /** @var  clientesRepository */
    private $clientesRepository;

    public function __construct(LancamentoReceberRepository $lancamentoReceberRepo, ClienteRepository $clientesRepo)
    {
        $this->lancamentoReceberRepository = $lancamentoReceberRepo;
        $this->clientesRepository = $clientesRepo;

        $this->middleware('permission:relatorio_contas_receber', ['only' => ['index','relatorio','doRelatorio','show','edit', 'update']]); 
    }

    public function relatorio()
    {
        /** Titulo da página */
        $title = "Relatório - Lançamentos e baixas a receber";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "relatorioLancamentoRecebers";

        $clientes = $this->clientesRepository->all(); // Todos os clientes, para o filtro

        return view('relatorio.contas_receber', compact('title', 'breadcrumb', 'clientes'));
    }

    public function doRelatorio(Request $request)
    {
        /** Titulo da página */
        $title = "Relatório - Lançamentos e baixas a receber";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "relatorioLancamentoRecebers";

        $input       = $request->all();
        $lancamentos = $this->lancamentoReceberRepository->relatorio($input);
        
        return view('relatorio.contas_receber_lista', compact('title', 'breadcrumb', 'lancamentos', 'input'));
    }
}
