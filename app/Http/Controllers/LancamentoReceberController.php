<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLancamentoReceberRequest;
use App\Http\Requests\UpdateLancamentoReceberRequest;
use App\Repositories\LancamentoReceberRepository;
use App\Repositories\ClienteRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\FormaDePagamentoRepository;
use App\Repositories\ContaBancariaRepository;
use App\Repositories\PlanoDeContasRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use DateTime;

class LancamentoReceberController extends AppBaseController
{
    /** @var  LancamentoReceberRepository */
    private $lancamentoReceberRepository;

    private $clientesRepository;

    /** @var  formaPagamentoRepository */
    private $formaPagamentoRepository;

    /** @var  ContasbancariasPagarRepository */
    private $contasbancariasPagarRepository;

    /** @var  PlanoDeContasRepository */
    private $planoDeContasRepository;

    public function __construct(
        LancamentoReceberRepository $lancamentoReceberRepo,
        ClienteRepository $clientesRepo,
        FormaDePagamentoRepository $formaPagamentoRepo,
        ContaBancariaRepository $contasBancariasRepo,
        PlanoDeContasRepository $planoDeContasRepo
        ) {
        $this->lancamentoReceberRepository = $lancamentoReceberRepo;
        $this->clientesRepository          = $clientesRepo;
        $this->formaPagamentoRepository       = $formaPagamentoRepo;
        $this->contasbancariasPagarRepository = $contasBancariasRepo;
        $this->planoDeContasRepository      = $planoDeContasRepo;

        $this->middleware('permission:lancamento_receber_listar', ['only' => ['index']]);
        $this->middleware('permission:lancamento_receber_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:lancamento_receber_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:lancamento_receber_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:lancamento_receber_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the LancamentoReceber.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();

        /** Titulo da página */
        $title = "Lançamento a Receber";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "lancamentoRecebers";

        
        if (!empty($filtros['search']) && !empty($request['search'])) {
            $explodeSearch = explode(":", $filtros['search']);
            if ($explodeSearch[0] == "data_emissao" || $explodeSearch[0] == "data_vencimento") {
                $data = date('Y-m-d', strtotime(str_replace("/", "-", $explodeSearch[1])));
                
                $filtros['search'] = $explodeSearch[0] . ":" . $data;
                $request['search'] = $explodeSearch[0] . ":" . $data;
            }
        }
        
        /** Filtros */
        $request = $this->setOrderBy($request);
        $this->lancamentoReceberRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->lancamentoReceberRepository->filter($filtros);

        if (isset($filtros['situacao'])) {
            if ($filtros['situacao'] == 'all') {
                $lancamentoRecebers = $this->lancamentoReceberRepository->scopeQuery(function ($query) use ($filtros) {
                    if (isset($filtros['search'])) {
                        if (strpos($filtros['search'], 'cliente') !== false) {
                            $query->join('clientes', 'clientes.id', '=', 'lancamentos_receber.cliente_id')->where('razaoSocial', 'like', '%'.getFilter('cliente', $filtros['search']).'%');
                        }
                    }
                    return $query->withTrashed(); // com deletados
                })->paginate();
            } elseif ($filtros['situacao'] == 'inativo') {
                $lancamentoRecebers = $this->lancamentoReceberRepository->scopeQuery(function ($query) use ($filtros) {
                    if (isset($filtros['search'])) {
                        if (strpos($filtros['search'], 'cliente') !== false) {
                            $query->join('clientes', 'clientes.id', '=', 'lancamentos_receber.cliente_id')->where('razaoSocial', 'like', '%'.getFilter('cliente', $filtros['search']).'%');
                        }
                    }
                    
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            } else {
                $lancamentoRecebers = $this->lancamentoReceberRepository->scopeQuery(function ($query) use ($filtros) {
                    if (isset($filtros['search'])) {
                        if (strpos($filtros['search'], 'cliente') !== false) {
                            $query->join('clientes', 'clientes.id', '=', 'lancamentos_receber.cliente_id')->where('razaoSocial', 'like', '%'.getFilter('cliente', $filtros['search']).'%');
                        }
                    }

                    return $query; // com deletados
                })->paginate();
            }
        } else {
            $lancamentoRecebers = $this->lancamentoReceberRepository->scopeQuery(function ($query) use ($filtros) {
                if (isset($filtros['search'])) {
                    if (strpos($filtros['search'], 'cliente') !== false) {
                        $query->join('clientes', 'clientes.id', '=', 'lancamentos_receber.cliente_id')->where('razaoSocial', 'like', '%'.getFilter('cliente', $filtros['search']).'%');
                    }
                }
                
                return $query; // com deletados
            })->paginate();
        }

        $formaPagamentos   = $this->formaPagamentoRepository->all();
        $lancamentoReceber = $this->lancamentoReceberRepository->all();
        $contasbancarias   = $this->contasbancariasPagarRepository->all();
        $planos_contas     = $this->planoDeContasRepository->all();

        return view('lancamento_recebers.index', compact('title', 'breadcrumb', 'planos_contas', 'lancamentoRecebers', 'filters', 'formaPagamentos', 'contasbancarias', 'lancamentoReceber'));
    }

    /**
     * Show the form for creating a new LancamentoReceber.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Lançamento a Receber";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addLancamentoRecebers";

        $lancamentoReceber = new \App\Models\LancamentoReceber;

        $lancamentoReceber->cliente_id ="";
        $clientes = $this->clientesRepository->all();

        return view('lancamento_recebers.create', compact('title', 'breadcrumb', 'lancamentoReceber', 'clientes'));
    }

    /**
     * Store a newly created LancamentoReceber in storage.
     *
     * @param CreateLancamentoReceberRequest $request
     *
     * @return Response
     */
    public function store(CreateLancamentoReceberRequest $request)
    {
        $input = $request->all();
        if (!empty($input['data_vencimento']) && count(explode('/', $input['data_vencimento'])) > 1) {
            $date = DateTime::createFromFormat('d/m/Y', $input['data_vencimento']);
            $usableDate = $date->format('Y-m-d');
            $input['data_vencimento'] =$usableDate;
        }
        if (!empty($input['data_emissao']) && count(explode('/', $input['data_emissao'])) > 1) {
            $date = DateTime::createFromFormat('d/m/Y', $input['data_emissao']);
            $usableDate = $date->format('Y-m-d');
            $input['data_emissao'] =$usableDate;
        }
        $input['valor_titulo'] = getRealValue($input['valor_titulo']);
        
        DB::beginTransaction();
        try {
            $lancamentoReceber = $this->lancamentoReceberRepository->create($input);
            $input['lancamento_receber_id'] = $lancamentoReceber->id;
            
            DB::commit();
            Flash::success('Lançamento a Receber salvo com sucesso.');
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Erro ao tentar cadastrar Lançamento a Receber ->'.$e->Message);
        }

        return redirect(route('lancamentoRecebers.index'));
    }

    /**
     * Display the specified LancamentoReceber.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $lancamentoReceber = $this->lancamentoReceberRepository->findWithoutFail($id);

        if (empty($lancamentoReceber)) {
            Flash::error('Lançamento a Receber não encontrado');

            return redirect(route('lancamentoRecebers.index'));
        }
        /** Titulo da página */
        $title = "Lançamento a Receber";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showLancamentoRecebers";
        $breadcrumb->titulo = $lancamentoReceber->id;

        return view('lancamento_recebers.show', compact('title', 'breadcrumb', 'lancamentoReceber'));
    }

    /**
     * Show the form for editing the specified LancamentoReceber.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $lancamentoReceber = $this->lancamentoReceberRepository->findWithoutFail($id);

        if (empty($lancamentoReceber)) {
            Flash::error('Lançamento a Receber não encontrado');

            return redirect(route('lancamentoRecebers.index'));
        }

        // Titulo da página
        $title = "Lançamento a Receber - ID:".$lancamentoReceber->id;
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editLancamentoRecebers";
        $breadcrumb->id = $lancamentoReceber->id;
        $breadcrumb->titulo = $lancamentoReceber->id;
        $clientes = $this->clientesRepository->all();

        return view('lancamento_recebers.edit', compact('title', 'breadcrumb', 'lancamentoReceber', 'clientes'));
    }

    /**
     * Update the specified LancamentoReceber in storage.
     *
     * @param  int              $id
     * @param UpdateLancamentoReceberRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLancamentoReceberRequest $request)
    {
        $lancamentoReceber = $this->lancamentoReceberRepository->findWithoutFail($id);

        if (empty($lancamentoReceber)) {
            Flash::error('Lançamento a Receber não encontrado');

            return redirect(route('lancamentoRecebers.index'));
        }
        
        $input=$request->all();

        if (!empty($input['data_vencimento']) && count(explode('/', $input['data_vencimento'])) > 1) {
            $date = DateTime::createFromFormat('d/m/Y', $input['data_vencimento']);
            $usableDate = $date->format('Y-m-d');
            $input['data_vencimento'] =$usableDate;
        }
        if (!empty($input['data_emissao']) && count(explode('/', $input['data_emissao'])) > 1) {
            $date = DateTime::createFromFormat('d/m/Y', $input['data_emissao']);
            $usableDate = $date->format('Y-m-d');
            $input['data_emissao'] =$usableDate;
        }


        $lancamentoReceber = $this->lancamentoReceberRepository->update($input, $id);

        Flash::success('Lançamento a Receber atualizado com sucesso.');

        return redirect(route('lancamentoRecebers.index'));
    }

    /**
     * Remove the specified LancamentoReceber from storage.
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
                $this->lancamentoReceberRepository->delete($id);
            }

            DB::commit();
            Flash::success('Lançamento(s) a Receber inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Lançamento(s) a Receber!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
