<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLancamentoReceberRequest;
use App\Http\Requests\UpdateLancamentoReceberRequest;
use App\Repositories\NegocioRepository;
use App\Repositories\UsuarioRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use DateTime;

class RelatorioNegociosPeriodoController extends Controller
{
    /** @var  negocioRepository */
    private $negocioRepository;
    /** @var  usuarioRepository */
    private $usuarioRepository;

    public function __construct(NegocioRepository $NegocioRepo, UsuarioRepository $UsuarioRepo)
    {
        $this->negocioRepository = $NegocioRepo;
        $this->usuarioRepository = $UsuarioRepo;
        
        $this->middleware('permission:relatorio_negocio_periodo', ['only' => ['index','relatorio','doRelatorio','show','edit', 'update']]); 

    }

    public function relatorio()
    {
        /** Titulo da página */
        $title = "Relatório - Negócios por Período";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "relatorioNegociosPeriodo";

        $usuarios = $this->usuarioRepository->all(); // Todos os usuarios, para o filtro

        return view('relatorio.negociosPeriodo', compact('title', 'breadcrumb', 'usuarios'));
    }

    public function doRelatorio(Request $request)
    {
        /** Titulo da página */
        $title = "Relatório - Negócios por Período";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "relatorioNegociosPeriodo";

        $input       = $request->all();
        $negocios = $this->negocioRepository->relatorio($input);
        
        return view('relatorio.negociosPeriodo_lista', compact('title', 'breadcrumb', 'negocios', 'input'));
    }
}
