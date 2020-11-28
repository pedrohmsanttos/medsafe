<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLancamentoReceberRequest;
use App\Http\Requests\UpdateLancamentoReceberRequest;
use App\Repositories\LancamentoReceberRepository;
use App\Repositories\PlanoDeContasRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ClienteRepository;
use App\Repositories\FornecedorRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use DateTime;

class RelatorioPlanoContasController extends Controller
{
    /** @var  lancamentoReceberRepository */
    private $lancamentoReceberRepository;

    /** @var  PlanoDeContasRepository */
    private $planoDeContasRepository;

    /** @var  ClienteRepository */
    private $clienteRepository;
 
    /** @var  FornecedorRepository */
    private $fornecedorRepository;

    public function __construct(
        LancamentoReceberRepository $lancamentoReceberRepo,
        PlanoDeContasRepository $planoDeContasRepo,
        ClienteRepository $clienteRepo,
        FornecedorRepository $fornecedorRepo
    ) {
        $this->lancamentoReceberRepository  = $lancamentoReceberRepo;
        $this->planoDeContasRepository      = $planoDeContasRepo;
        $this->clienteRepository            = $clienteRepo;
        $this->fornecedorRepository         = $fornecedorRepo;

        $this->middleware('permission:relatorio_plano_contas', ['only' => ['index','relatorio','doRelatorio','show','edit', 'update']]); 
    }

    public function relatorio()
    {
        /** Titulo da página */
        $title = "Relatório - Plano de contas";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "relatorioPlanoContas";

        $clientes                       = $this->clienteRepository->all();
        $fornecedores                   = $this->fornecedorRepository->all();
        $planoDeContas = $this->planoDeContasRepository->all(); // Todos os planos de contas

        return view('relatorio.plano_de_contas', compact('title', 'breadcrumb', 'planoDeContas', 'clientes', 'fornecedores'));
    }

    public function doRelatorio(Request $request)
    {
        /** Titulo da página */
        $title = "Relatório - Plano de Contas";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "relatorioPlanoContas";

        $input          = $request->all();
        $planosDeContas = $this->planoDeContasRepository->relatorio($input);
        
        return view('relatorio.plano_de_contas_lista', compact('title', 'breadcrumb', 'planosDeContas', 'input'));
    }
}
