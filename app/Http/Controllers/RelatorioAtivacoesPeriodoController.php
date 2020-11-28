<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLancamentoReceberRequest;
use App\Http\Requests\UpdateLancamentoReceberRequest;
use App\Repositories\NegocioRepository;
use App\Repositories\UsuarioRepository;
use App\Repositories\ApoliceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use DateTime;
use Auth;

class RelatorioAtivacoesPeriodoController extends Controller
{
    /** @var  negocioRepository */
    private $negocioRepository;
    /** @var  usuarioRepository */
    private $usuarioRepository;
    /** @var  apoliceRepository */
    private $apoliceRepository;

    public function __construct(NegocioRepository $NegocioRepo, UsuarioRepository $UsuarioRepo,ApoliceRepository $ApoliceRepo)
    {
        $this->negocioRepository = $NegocioRepo;
        $this->usuarioRepository = $UsuarioRepo;
        $this->apoliceRepository = $ApoliceRepo;
    }

    public function relatorio()
    {
        /** Titulo da página */
        $title = "Relatório - Ativações por Período";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "relatorioAtivacoesPeriodo";

        $usuarios = $this->usuarioRepository->all(); // Todos os usuarios, para o filtro

        return view('relatorio.ativacoesPeriodo', compact('title', 'breadcrumb', 'usuarios'));
    }

    public function doRelatorio(Request $request)
    {
        /** Titulo da página */
        $title = "Relatório - Ativações por Período";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "relatorioAtivacoesPeriodo";

        $input       = $request->all();
        $user = Auth::user();
        $input['corretor'] = $user->corretor()->first()->id;
        $input = $this->verifyDate($input);
        $apolices = $this->apoliceRepository->relatorio($input);
        return view('relatorio.ativacoesPeriodo_lista', compact('title', 'breadcrumb', 'apolices', 'input'));
    }

    public function verifyDate($input)
    {
        if($input['data_inicial'] == '' && !isset($input['data_inicial']) && $input['data_final'] != '' && isset($input['data_final']) ){
            $input['data_inicial'] = '01/01/1980';
        } else if( $input['data_final'] == '' && !isset($input['data_final']) && $input['data_inicial'] != '' && isset($input['data_inicial']) ){
            date_default_timezone_set('America/Recife');
            $input['data_final'] = date('d/m/Y', time());
        }

        return $input;
    }
}
