<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBaixaReceberRequest;
use App\Http\Requests\UpdateBaixaReceberRequest;
use App\Repositories\BaixaReceberRepository;
use App\Repositories\FormaDePagamentoRepository;
use App\Repositories\LancamentoReceberRepository;
use App\Repositories\PlanoDeContasRepository;
use App\Repositories\ContaBancariaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use App\Events\BaixaLancamentoReceber;

class BaixaReceberController extends AppBaseController
{
    /** @var  BaixaReceberRepository */
    private $baixaReceberRepository;

    /** @var  formaPagamentoRepository */
    private $formaPagamentoRepository;

    /** @var  BaixaReceberRepository */
    private $lancamentoReceberRepository;

    /** @var  ContasbancariasPagarRepository */
    private $contasbancariasPagarRepository;

    /** @var  PlanoDeContasRepository */
    private $planoDeContasRepository;

    public function __construct(
        BaixaReceberRepository $baixaReceberRepo,
        FormaDePagamentoRepository $formaPagamentoRepo,
        LancamentoReceberRepository $lancamentoReceberRepo,
        ContaBancariaRepository $contasBancariasRepo,
        PlanoDeContasRepository $planoDeContasRepo
    ) {
        $this->baixaReceberRepository         = $baixaReceberRepo;
        $this->formaPagamentoRepository       = $formaPagamentoRepo;
        $this->lancamentoReceberRepository    = $lancamentoReceberRepo;
        $this->contasbancariasPagarRepository = $contasBancariasRepo;
        $this->planoDeContasRepository        = $planoDeContasRepo;
        // Set Permissions
        $this->middleware('permission:baixaReceber_listar', ['only' => ['index']]);
        $this->middleware('permission:baixaReceber_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:baixaReceber_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:baixaReceber_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:baixaReceber_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the BaixaReceber.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();

        /** Titulo da página */
        $title = "Baixa de Lançamento a Receber";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "baixaReceber";


        if (!empty($filtros['search']) && !empty($request['search'])) {
            $explodeSearch = explode(":", $filtros['search']);
            if ($explodeSearch[0] == "disponibilidade" || $explodeSearch[0] == "baixa") {
                $data = date('Y-m-d', strtotime(str_replace("/", "-", $explodeSearch[1])));
                
                $filtros['search'] = $explodeSearch[0] . ":" . $data;
                $request['search'] = $explodeSearch[0] . ":" . $data;
            }
        }

        /** Filtros */
        $request = $this->setOrderBy($request);
        $this->baixaReceberRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->baixaReceberRepository->filter($filtros);

        if (isset($filtros['situacao'])) {
            if ($filtros['situacao'] == 'all') {
                $baixaRecebers = $this->baixaReceberRepository->scopeQuery(function ($query) {
                    return $query->orderBy('id', 'desc')->withTrashed(); // com deletados
                })->paginate();
            } elseif ($filtros['situacao'] == 'inativo') {
                $baixaRecebers = $this->baixaReceberRepository->scopeQuery(function ($query) {
                    return $query->orderBy('id', 'desc')->onlyTrashed(); // só os deletados
                })->paginate();
            } else {
                $baixaRecebers = $this->baixaReceberRepository->scopeQuery(function ($query) {
                    return $query->orderBy('id', 'desc'); // só os deletados
                })->paginate();
            }
        } else {
            $baixaRecebers = $this->baixaReceberRepository->scopeQuery(function ($query) {
                return $query->orderBy('id', 'desc'); // só os deletados
            })->paginate();
        }

        $formaPagamentos   = $this->formaPagamentoRepository->all();
        $lancamentoReceber = $this->lancamentoReceberRepository->all();
        $contasbancarias   = $this->contasbancariasPagarRepository->all();

        return view('baixa_recebers.index', compact('title', 'breadcrumb', 'baixaRecebers', 'filters', 'formaPagamentos', 'lancamentoReceber', 'contasbancarias'));
    }

    /**
     * Show the form for creating a new BaixaReceber.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Baixa de Lançamento a Receber";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addbaixaReceber";

        $formaPagamentos = $this->formaPagamentoRepository->all();
        $lancamentoReceber = $this->lancamentoReceberRepository->all();
        $contasbancarias = $this->contasbancariasPagarRepository->all();
        $planos_contas   = $this->planoDeContasRepository->all();

        return view('baixa_recebers.create', compact('title', 'breadcrumb', 'formaPagamentos', 'planos_contas', 'lancamentoReceber', 'contasbancarias'));
    }

    /**
     * Store a newly created BaixaReceber in storage.
     *
     * @param CreateBaixaReceberRequest $request
     *
     * @return Response
     */
    public function store(CreateBaixaReceberRequest $request)
    {
        $input = $request->all();// request

        if (isset($input['disponibilidade'])) {
            $input['disponibilidade'] = dateBRtoSQL($input['disponibilidade']);
        }
        
        $input['baixa']           = dateBRtoSQL($input['baixa']);
        $input['valor_pago']      = getRealValue($input['valor_pago']);

        if (isset($input['valor_residual'])) {
            $input['valor_residual'] = getRealValue($input['valor_residual']);
        }
        

        try {
            $baixaReceber = $this->baixaReceberRepository->create($input);

            Flash::success('Baixa e Conta a Receber salvo com sucesso.');
        } catch (Exception $e) {
            Flash::success('Ocorreu um erro ao salvar Baixa e Conta a Receber!');
        }

        event(new BaixaLancamentoReceber($baixaReceber));

        return redirect(route('baixareceber.index'));
    }

    /**
     * Display the specified BaixaReceber.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Baixa de Lançamento a Receber";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showbaixaReceber";
        
        $baixaReceber = $this->baixaReceberRepository->findWithoutFail($id);

        if (empty($baixaReceber)) {
            Flash::error('Baixa Receber não encontrado');

            return redirect(route('baixareceber.index'));
        }

        return view('baixa_recebers.show', compact('title', 'breadcrumb', 'baixaReceber'));
    }

    /**
     * Show the form for editing the specified BaixaReceber.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $baixaReceber = $this->baixaReceberRepository->findWithoutFail($id);

        if (empty($baixaReceber)) {
            Flash::error('Baixa Receber não encontrado');

            return redirect(route('baixareceber.index'));
        }

        // Titulo da página
        $title = "Baixa de Lançamento a Receber";
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editbaixaReceber";
        $breadcrumb->id = $baixaReceber->id;
        $breadcrumb->titulo = $baixaReceber->id;

        $formaPagamentos = $this->formaPagamentoRepository->all();
        $lancamentoReceber = $this->lancamentoReceberRepository->all();
        $contasbancarias = $this->contasbancariasPagarRepository->all();
        $planos_contas   = $this->planoDeContasRepository->all();

        return view('baixa_recebers.edit', compact('title', 'breadcrumb', 'planos_contas', 'baixaReceber', 'formaPagamentos', 'lancamentoReceber', 'contasbancarias'));
    }

    /**
     * Update the specified BaixaReceber in storage.
     *
     * @param  int              $id
     * @param UpdateBaixaReceberRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBaixaReceberRequest $request)
    {
        $baixaReceber = $this->baixaReceberRepository->findWithoutFail($id);

        if (empty($baixaReceber)) {
            Flash::error('Baixa Receber não encontrado');

            return redirect(route('baixareceber.index'));
        }

        $input = $request->all();

        $input['disponibilidade'] = dateBRtoSQL($input['disponibilidade']);
        $input['baixa']           = dateBRtoSQL($input['baixa']);
        $input['valor_pago']      = getRealValue($input['valor_pago']);
        $input['valor_residual']  = getRealValue($input['valor_residual']);

        $baixaReceber = $this->baixaReceberRepository->update($input, $id);

        Flash::success('Baixa de contas a receber atualizado com sucesso.');

        return redirect(route('baixareceber.index'));
    }

    /**
     * Remove the specified BaixaReceber from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        $input = $request->all();
        $ids   = $input['ids'];

        DB::beginTransaction();
        try {
            foreach ($ids as $id) {
                $this->baixaReceberRepository->delete($id);
            }

            DB::commit();
            Flash::success('Registro(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar registro(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
