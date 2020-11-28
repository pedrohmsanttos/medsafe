<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLancamentoPagarRequest;
use App\Http\Requests\UpdateLancamentoPagarRequest;
use App\Repositories\LancamentoPagarRepository;
use App\Repositories\FormaDePagamentoRepository;
use App\Repositories\ContaBancariaRepository;
use App\Repositories\PlanoDeContasRepository;
use App\Repositories\FornecedorRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DateTime;
use DB;

class LancamentoPagarController extends AppBaseController
{
    /** @var  LancamentoPagarRepository */
    private $lancamentoPagarRepository;

    /** @var  FornecedorRepository */
    private $fornecedorRepository;

    /** @var  FormaPagamentoRepository */
    private $formaPagamentoRepository;

    /** @var  ContasbancariasRepository */
    private $contasbancariasRepository;

    /** @var  PlanoDeContasRepository */
    private $planoDeContasRepository;

    public function __construct(
        LancamentoPagarRepository $lancamentoPagarRepo,
        FornecedorRepository $fornecedorRepository,
        FormaDePagamentoRepository $formaPagamentoRepo,
        ContaBancariaRepository $contasBancariasRepo,
        PlanoDeContasRepository $planoDeContasRepo
        ) {
        $this->lancamentoPagarRepository    = $lancamentoPagarRepo;
        $this->fornecedorRepository         = $fornecedorRepository;
        $this->formaPagamentoRepository     = $formaPagamentoRepo;
        $this->contasbancariasRepository    = $contasBancariasRepo;
        $this->planoDeContasRepository      = $planoDeContasRepo;

        // Set Permissions
        $this->middleware('permission:lancamento_pagar_listar', ['only' => ['index']]);
        $this->middleware('permission:lancamento_pagar_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:lancamento_pagar_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:lancamento_pagar_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:lancamento_pagar_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the LancamentoPagar.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();

        /** Titulo da página */
        $title = "Lançamento a Pagar";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "lancamentosPagar";
        /** Filtros */
        if (!empty($filtros['search']) && !empty($request['search'])) {
            $explodeSearch = explode(":", $filtros['search']);
            if ($explodeSearch[0] == "data_emissao" || $explodeSearch[0] == "data_vencimento") {
                $data = date('Y-m-d', strtotime(str_replace("/", "-", $explodeSearch[1])));
            
                $filtros['search'] = $explodeSearch[0] . ":" . $data;
                $request['search'] = $explodeSearch[0] . ":" . $data;
            }
        }

        $request = $this->setOrderBy($request);
        $this->lancamentoPagarRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->lancamentoPagarRepository->filter($filtros);

        if (isset($filtros['situacao'])) {
            if ($filtros['situacao'] == 'all') {
                $lancamentosPagar = $this->lancamentoPagarRepository->scopeQuery(function ($query) {
                    return $query->withTrashed(); // com deletados
                })->paginate();
            } elseif ($filtros['situacao'] == 'inativo') {
                $lancamentosPagar = $this->lancamentoPagarRepository->scopeQuery(function ($query) {
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            } else {
                $lancamentosPagar = $this->lancamentoPagarRepository->paginate();
            }
        } else {
            $lancamentosPagar = $this->lancamentoPagarRepository->paginate();
        }

        $fornecedores = $this->fornecedorRepository->all();

        $formaPagamentos = $this->formaPagamentoRepository->all();
        $lancamentoPagar = $this->lancamentoPagarRepository->orderBy('id', 'desc')->all();
        $contasbancarias = $this->contasbancariasRepository->all();
        $planos_contas   = $this->planoDeContasRepository->all();

        return view('lancamento_pagars.index', compact('title', 'breadcrumb', 'planos_contas', 'lancamentosPagar', 'filters', 'fornecedores', 'formaPagamentos', 'lancamentoPagar', 'contasbancarias'));
    }

    /**
     * Show the form for creating a new LancamentoPagar.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Lançamento a Pagar";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addLancamentoPagar";

        $lancamentoPagar = new \App\Models\LancamentoPagar;
        $lancamentoPagar->fornecedor_id ="";
        $fornecedores = $this->fornecedorRepository->all();

        return view('lancamento_pagars.create', compact('title', 'breadcrumb', 'lancamentoPagar', 'fornecedores'));
    }

    /**
     * Store a newly created LancamentoPagar in storage.
     *
     * @param CreateLancamentoPagarRequest $request
     *
     * @return Response
     */
    public function store(CreateLancamentoPagarRequest $request)
    {
        $input = $request->all();
        
        if (!empty($input['data_vencimento']) && count(explode('/', $input['data_vencimento'])) > 1) {
            $dateVecimento = DateTime::createFromFormat('d/m/Y', $input['data_vencimento']);
            $usableDate = $dateVecimento->format('Y-m-d');
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
            if (isset($input['recorrencia']) && $input['recorrencia'] > 1) {
                for ($i = 0; $i < $input['recorrencia']; ++$i) {
                    if ($i > 0) {
                        $dateVecimento->modify('+1 month');
                    }
                    $dataTemp = $dateVecimento->format('Y-m-d');
                    $input['data_vencimento'] = $dataTemp;
                    $lancamentoPagar = $this->lancamentoPagarRepository->create($input);
                }
            } else {
                $lancamentoPagar = $this->lancamentoPagarRepository->create($input);
                $input['lancamento_pagar_id'] = $lancamentoPagar->id;
            }

            DB::commit();
            Flash::success('Lançamento a Pagar salvo com sucesso.');
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Erro ao tentar cadastrar Lançamento a Pagar: '.$e->Message);
        }

        return redirect(route('lancamentosPagar.index'));
    }

    /**
     * Display the specified LancamentoPagar.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Lancamento Pagar";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showLancamento Pagar";
        
        $lancamentoPagar = $this->lancamentoPagarRepository->findWithoutFail($id);

        if (empty($lancamentoPagar)) {
            Flash::error('Lancamento Pagar não encontrado');

            return redirect(route('lancamentosPagar.index'));
        }

        return view('lancamento_pagars.show', compact('title', 'breadcrumb', 'lancamentoPagar'));
    }

    /**
     * Show the form for editing the specified LancamentoPagar.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $lancamentoPagar = $this->lancamentoPagarRepository->findWithoutFail($id);

        if (empty($lancamentoPagar)) {
            Flash::error('Lancamento Pagar não encontrado');

            return redirect(route('lancamentosPagar.index'));
        }

        // Titulo da página
        $title = "Lançamento a Pagar";
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editLancamentoPagar";
        $breadcrumb->id = $lancamentoPagar->id;
        $breadcrumb->titulo = $lancamentoPagar->id;

        $fornecedores = $this->fornecedorRepository->all();

        return view('lancamento_pagars.edit', compact('title', 'breadcrumb', 'lancamentoPagar', 'fornecedores'));
    }

    /**
     * Update the specified LancamentoPagar in storage.
     *
     * @param  int              $id
     * @param UpdateLancamentoPagarRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLancamentoPagarRequest $request)
    {
        $lancamentoPagar = $this->lancamentoPagarRepository->findWithoutFail($id);

        if (empty($lancamentoPagar)) {
            Flash::error('Lancamento Pagar não encontrado');

            return redirect(route('lancamentosPagar.index'));
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

        $lancamentoPagar = $this->lancamentoPagarRepository->update($input, $id);

        Flash::success('Lancamento Pagar atualizado com sucesso.');

        return redirect(route('lancamentosPagar.index'));
    }

    /**
     * Remove the specified LancamentoPagar from storage.
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
                $this->lancamentoPagarRepository->delete($id);
            }

            DB::commit();
            Flash::success('Lancamento Pagar(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Lancamento Pagar(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
