<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBaixaPagarRequest;
use App\Http\Requests\UpdateBaixaPagarRequest;
use App\Repositories\BaixaPagarRepository;
use App\Repositories\FormaDePagamentoRepository;
use App\Repositories\LancamentoPagarRepository;
use App\Repositories\ContaBancariaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\BaixaPagar;
use App\Events\BaixaLancamentoPagar;
use App\Repositories\PlanoDeContasRepository;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class BaixaPagarController extends AppBaseController
{
    /** @var  BaixaPagarRepository */
    private $baixaPagarRepository;

    /** @var  FormaPagamentoRepository */
    private $formaPagamentoRepository;

    /** @var  LancamentoPagarRepository */
    private $lancamentoPagarRepository;

    /** @var  ContasbancariasRepository */
    private $contasbancariasRepository;

    /** @var  PlanoDeContasRepository */
    private $planoDeContasRepository;

    public function __construct(
        BaixaPagarRepository $baixaPagarRepo,
        FormaDePagamentoRepository $formaPagamentoRepo,
        LancamentoPagarRepository $lancamentoPagarRepo,
        ContaBancariaRepository $contasBancariasRepo,
        PlanoDeContasRepository $planoDeContasRepo
    ) {
        $this->baixaPagarRepository           = $baixaPagarRepo;
        $this->formaPagamentoRepository       = $formaPagamentoRepo;
        $this->lancamentoPagarRepository      = $lancamentoPagarRepo;
        $this->contasbancariasRepository      = $contasBancariasRepo;
        $this->planoDeContasRepository        = $planoDeContasRepo;
        // Set Permissions
        $this->middleware('permission:baixaPagar_listar', ['only' => ['index']]);
        $this->middleware('permission:baixaPagar_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:baixaPagar_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:baixaPagar_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:baixaPagar_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the BaixaPagar.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();

        /** Titulo da página */
        $title = "Baixa de Lançamento a Pagar";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "baixaPagar";


        if (!empty($filtros['search']) && !empty($request['search'])) {
            $explodeSearch = explode(":", $filtros['search']);
            if ($explodeSearch[0] == "diponibilidade" || $explodeSearch[0] == "baixa") {
                $data = date('Y-m-d', strtotime(str_replace("/", "-", $explodeSearch[1])));
                
                $filtros['search'] = $explodeSearch[0] . ":" . $data;
                $request['search'] = $explodeSearch[0] . ":" . $data;
            }
        }

        /** Filtros */
        $request = $this->setOrderBy($request);
        $this->baixaPagarRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->baixaPagarRepository->filter($filtros);

        if (isset($filtros['situacao'])) {
            if ($filtros['situacao'] == 'all') {
                $baixapagar = $this->baixaPagarRepository->scopeQuery(function ($query) {
                    return $query->withTrashed(); // com deletados
                })->paginate();
            } elseif ($filtros['situacao'] == 'inativo') {
                $baixapagar = $this->baixaPagarRepository->scopeQuery(function ($query) {
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            } else {
                $baixapagar = $this->baixaPagarRepository->paginate();
            }
        } else {
            $baixapagar = $this->baixaPagarRepository->paginate();
        }

        $formaPagamentos = $this->formaPagamentoRepository->all();
        $lancamentoPagar = $this->lancamentoPagarRepository->all();
        $contasbancarias = $this->contasbancariasRepository->all();

        return view('baixa_pagars.index', compact('title', 'breadcrumb', 'baixapagar', 'filters', 'formaPagamentos', 'lancamentoPagar', 'contasbancarias'));
    }

    /**
     * Show the form for creating a new BaixaPagar.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Baixa de Lançamento a Pagar";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addbaixaPagar";
        
        $formaPagamentos = $this->formaPagamentoRepository->all();
        $lancamentoPagar = $this->lancamentoPagarRepository->all();
        $contasbancarias = $this->contasbancariasRepository->all();
        $planos_contas   = $this->planoDeContasRepository->all();

        return view('baixa_pagars.create', compact('title', 'breadcrumb', 'formaPagamentos', 'planos_contas', 'lancamentoPagar', 'contasbancarias'));
    }

    /**
     * Store a newly created BaixaPagar in storage.
     *
     * @param CreateBaixaPagarRequest $request
     *
     * @return Response
     */
    public function store(CreateBaixaPagarRequest $request)
    {
        $input = $request->all();
        
        $input['disponibilidade'] = dateBRtoSQL($input['disponibilidade']);
        if ($input['disponibilidade'] == '') {
            unset($input['disponibilidade']);
        }
        $input['baixa']           = dateBRtoSQL($input['baixa']);
        $input['valor_pago']      = getRealValue($input['valor_pago']);
        $input['valor_residual']  = getRealValue($input['valor_residual']);

        try {
            $baixaPagar = $this->baixaPagarRepository->create($input);

            Flash::success('Baixa de Lançamento a Pagar salvo com sucesso.');
        } catch (Exception $e) {
            Flash::success('Ocorreu um erro ao salvar Baixa de Lançamento a Pagar');
        }
            
        event(new BaixaLancamentoPagar($baixaPagar));

        return redirect(route('baixapagar.index'));
    }

    /**
     * Display the specified BaixaPagar.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Baixa de Lançamento a Pagar";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showbaixaPagar";
        
        $baixaPagar = $this->baixaPagarRepository->findWithoutFail($id);

        if (empty($baixaPagar)) {
            Flash::error('Baixa Pagar não encontrado');

            return redirect(route('baixapagar.index'));
        }

        return view('baixa_pagars.show', compact('title', 'breadcrumb', 'baixaPagar'));
    }

    /**
     * Show the form for editing the specified BaixaPagar.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $baixaPagar = $this->baixaPagarRepository->findWithoutFail($id);
  
        if (empty($baixaPagar)) {
            Flash::error('Baixa Pagar não encontrado');

            return redirect(route('baixapagar.index'));
        }

        // Titulo da página
        $title = "Baixa de Lançamento a Pagar";
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editbaixaPagar";
        $breadcrumb->id = $baixaPagar->id;
        $breadcrumb->titulo = $baixaPagar->id;

        $formaPagamentos = $this->formaPagamentoRepository->all();
        $lancamentoPagar = $this->lancamentoPagarRepository->all();
        $contasbancarias = $this->contasbancariasRepository->all();
        $planos_contas   = $this->planoDeContasRepository->all();

        return view('baixa_pagars.edit', compact('title', 'breadcrumb', 'baixaPagar', 'planos_contas', 'formaPagamentos', 'lancamentoPagar', 'contasbancarias'));
    }

    /**
     * Update the specified BaixaPagar in storage.
     *
     * @param  int              $id
     * @param UpdateBaixaPagarRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBaixaPagarRequest $request)
    {
        $baixaPagar = $this->baixaPagarRepository->findWithoutFail($id);

        if (empty($baixaPagar)) {
            Flash::error('Baixa Pagar não encontrado');

            return redirect(route('baixapagar.index'));
        }

        $input = $request->all();

        $input['disponibilidade'] = dateBRtoSQL($input['disponibilidade']);
        $input['baixa']           = dateBRtoSQL($input['baixa']);
        $input['valor_pago']      = (float) str_replace('R$ ', '', str_replace(',', '.', $input['valor_pago']));
        $input['valor_residual']  = (float) str_replace('R$ ', '', str_replace(',', '.', $input['valor_residual']));

        $baixaPagar = $this->baixaPagarRepository->update($input, $id);

        Flash::success('Baixa de Lançamento a Pagar atualizado com sucesso.');

        return redirect(route('baixapagar.index'));
    }

    /**
     * Remove the specified BaixaPagar from storage.
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
                $this->baixaPagarRepository->delete($id);
            }

            DB::commit();
            Flash::success('Baixa de conta(s) a Pagar inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar baixa de conta(s) a pagar!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
