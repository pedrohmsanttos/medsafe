<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLancamentoPagarRequest;
use App\Http\Requests\UpdateLancamentoPagarRequest;
use App\Repositories\LancamentoPagarRepository;
use App\Repositories\FornecedorRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use DateTime;

class RelatorioLancamentoPagarController extends Controller
{
    /** @var  lancamentoPagarRepository */
    private $lancamentoPagarRepository;
    /** @var  FornecedorRepository */
    private $fornecedorRepository;

    public function __construct(LancamentoPagarRepository $lancamentoPagarRepo, FornecedorRepository $fornecedorRepo)
    {
        $this->lancamentoPagarRepository = $lancamentoPagarRepo;
        $this->fornecedorRepository = $fornecedorRepo;

        $this->middleware('permission:relatorio_contas_pagar', ['only' => ['index','relatorio','doRelatorio','show','edit', 'update']]); 

    }

    public function relatorio()
    {
        /** Titulo da página */
        $title = "Relatório - Lançamentos e baixas a pagar";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "relatorioLancamentoPagar";

        $fornecedores = $this->fornecedorRepository->all(); // Todos os fornecedores, para o filtro

        return view('relatorio.contas_pagar', compact('title', 'breadcrumb', 'fornecedores'));
    }

    public function doRelatorio(Request $request)
    {
        /** Titulo da página */
        $title = "Relatório lançamentos e baixas a pagar";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "relatorioLancamentoPagar";

        $input       = $request->all();
        $lancamentos = $this->lancamentoPagarRepository->relatorio($input);

        return view('relatorio.contas_pagar_lista', compact('title', 'breadcrumb', 'lancamentos', 'input'));
    }
}
