<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTesourariaRequest;
use App\Http\Requests\UpdateTesourariaRequest;
use App\Repositories\TesourariaRepository;
use App\Repositories\ClienteRepository;
use App\Repositories\FornecedorRepository;
use App\Repositories\FormaDePagamentoRepository;
use App\Repositories\PlanoDeContasRepository;
use App\Repositories\ContaBancariaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Events\EntradaTesouraria;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use DateTime;

class TesourariaController extends AppBaseController
{
    /** @var  TesourariaRepository */
    private $tesourariaRepository;

    /** @var  ClienteRepository */
    private $clienteRepository;

    /** @var  FornecedorRepository */
    private $fornecedorRepository;

    /** @var  FormaDePagamentoRepository */
    private $formaDePagamentoRepository;

    /** @var  PlanoDeContasRepository */
    private $planoDeContasRepository;

    /** @var  ContasbancariasRepository */
    private $contasbancariasRepository;

    public function __construct(
        TesourariaRepository $tesourariaRepo,
        ClienteRepository $clienteRepo,
        FornecedorRepository $fornecedorRepo,
        FormaDePagamentoRepository $formaDePagamentoRepository,
        PlanoDeContasRepository $planoDeContasRepository,
        ContaBancariaRepository $contasBancariasRepo
    ) {
        $this->tesourariaRepository         = $tesourariaRepo;
        $this->clienteRepository            = $clienteRepo;
        $this->fornecedorRepository         = $fornecedorRepo;
        $this->formaDePagamentoRepository   = $formaDePagamentoRepository;
        $this->planoDeContasRepository      = $planoDeContasRepository;
        $this->contasbancariasRepository    = $contasBancariasRepo;

        // Set Permissions
        $this->middleware('permission:tesouraria_listar', ['only' => ['index']]);
        $this->middleware('permission:tesouraria_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:tesouraria_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:tesouraria_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:tesouraria_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Tesouraria.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();

        /** Titulo da página */
        $title = "Tesourarias";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "tesourarias";
        /** Filtros */

        if (!empty($filtros['search']) && !empty($request['search'])) {
            $explodeSearch = explode(":", $filtros['search']);
            if ($explodeSearch[0] == "data_emissao" || $explodeSearch[0] == "data_vencimento" || $explodeSearch[0] == "data_disponibilidade") {
                $data = date('Y-m-d', strtotime(str_replace("/", "-", $explodeSearch[1])));
                
                $filtros['search'] = $explodeSearch[0] . ":" . $data;
                $request['search'] = $explodeSearch[0] . ":" . $data;
            }
        }

        $this->tesourariaRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->tesourariaRepository->filter($filtros);

        $fornecedores           = $this->fornecedorRepository->all();
        $clientes               = $this->clienteRepository->all();
        $formas_de_pagamento    = $this->formaDePagamentoRepository->all();

        if (isset($filtros['situacao'])) {
            if ($filtros['situacao'] == 'all') {
                $tesourarias = $this->tesourariaRepository->scopeQuery(function ($query) {
                    return $query->orderBy('id', 'desc')->withTrashed(); // com deletados
                })->paginate();
            } elseif ($filtros['situacao'] == 'inativo') {
                $tesourarias = $this->tesourariaRepository->scopeQuery(function ($query) {
                    return $query->orderBy('id', 'desc')->onlyTrashed(); // só os deletados
                })->paginate();
            } else {
                $tesourarias = $this->tesourariaRepository->scopeQuery(function ($query) {
                    return $query->orderBy('id', 'desc');
                })->paginate();
            }
        } else {
            $tesourarias = $this->tesourariaRepository->scopeQuery(function ($query) {
                return $query->orderBy('id', 'desc');
            })->paginate();
        }

        return view('tesourarias.index', compact('title', 'breadcrumb', 'tesourarias', 'filters', 'fornecedores', 'clientes', 'formas_de_pagamento'));
    }

    /**
     * Show the form for creating a new Tesouraria.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Tesouraria";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addTesouraria";

        $tesouraria = new \App\Models\Tesouraria;

        $tesouraria->cliente_id         = "";
        $tesouraria->fornecedor_id      = "";
        $tesouraria->tipo_pagamento_id  = "";
        $clientes                       = $this->clienteRepository->all();
        $fornecedores                   = $this->fornecedorRepository->all();
        $formas_de_pagamento            = $this->formaDePagamentoRepository->all();
        $planos_de_conta                = $this->planoDeContasRepository->all();
        $contasbancarias                = $this->contasbancariasRepository->all();
      

        return view('tesourarias.create', compact('title', 'breadcrumb', 'contasbancarias', 'tesouraria', 'clientes', 'fornecedores', 'formas_de_pagamento', 'planos_de_conta'));
    }

    /**
     * Store a newly created Tesouraria in storage.
     *
     * @param CreateTesourariaRequest $request
     *
     * @return Response
     */
    public function store(CreateTesourariaRequest $request)
    {
        $input = $request->all();

        if (!empty($input['data_vencimento']) && count(explode('/', $input['data_vencimento'])) > 1) {
            $date = DateTime::createFromFormat('d/m/Y', $input['data_vencimento']);
            $usableDate = $date->format('Y-m-d');
            $input['data_vencimento'] =$usableDate;
        }
        if (!empty($input['data_disponibilidade']) && count(explode('/', $input['data_disponibilidade'])) > 1) {
            $date = DateTime::createFromFormat('d/m/Y', $input['data_disponibilidade']);
            $usableDate = $date->format('Y-m-d');
            $input['data_disponibilidade'] =$usableDate;
        }
        if (!empty($input['data_emissao']) && count(explode('/', $input['data_emissao'])) > 1) {
            $date = DateTime::createFromFormat('d/m/Y', $input['data_emissao']);
            $usableDate = $date->format('Y-m-d');
            $input['data_emissao'] =$usableDate;
        }

        $tesouraria = $this->tesourariaRepository->create($input);

        event(new EntradaTesouraria($tesouraria));

        Flash::success('Tesouraria salva com sucesso.');

        return redirect(route('tesourarias.index'));
    }

    /**
     * Display the specified Tesouraria.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Tesouraria";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showTesouraria";
        
        $tesouraria = $this->tesourariaRepository->findWithoutFail($id);

        if (empty($tesouraria)) {
            Flash::error('Tesouraria não encontrada');

            return redirect(route('tesourarias.index'));
        }

        return view('tesourarias.show', compact('title', 'breadcrumb', 'tesouraria'));
    }

    /**
     * Show the form for editing the specified Tesouraria.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $tesouraria = $this->tesourariaRepository->findWithoutFail($id);

        if (empty($tesouraria)) {
            Flash::error('Tesouraria não encontrada');

            return redirect(route('tesourarias.index'));
        }

        // Titulo da página
        $title = "Tesouraria";
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editTesouraria";
        $breadcrumb->id = $tesouraria->id;
        $breadcrumb->titulo = $tesouraria->id;

        $clientes                       = $this->clienteRepository->all();
        $fornecedores                   = $this->fornecedorRepository->all();
        $formas_de_pagamento            = $this->formaDePagamentoRepository->all();
        $planos_de_conta                = $this->planoDeContasRepository->all();
        $contasbancarias                = $this->contasbancariasRepository->all();

        return view('tesourarias.edit', compact('title', 'breadcrumb', 'contasbancarias', 'tesouraria', 'clientes', 'fornecedores', 'formas_de_pagamento', 'planos_de_conta'));
    }

    /**
     * Update the specified Tesouraria in storage.
     *
     * @param  int              $id
     * @param UpdateTesourariaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTesourariaRequest $request)
    {
        $tesouraria = $this->tesourariaRepository->findWithoutFail($id);

        if (empty($tesouraria)) {
            Flash::error('Tesouraria não encontrada');

            return redirect(route('tesourarias.index'));
        }


        $input = $request->all();

        if (!empty($input['data_vencimento']) && count(explode('/', $input['data_vencimento'])) > 1) {
            $date = DateTime::createFromFormat('d/m/Y', $input['data_vencimento']);
            $usableDate = $date->format('Y-m-d');
            $input['data_vencimento'] =$usableDate;
        }
        if (!empty($input['data_disponibilidade']) && count(explode('/', $input['data_disponibilidade'])) > 1) {
            $date = DateTime::createFromFormat('d/m/Y', $input['data_disponibilidade']);
            $usableDate = $date->format('Y-m-d');
            $input['data_disponibilidade'] =$usableDate;
        }
        if (!empty($input['data_emissao']) && count(explode('/', $input['data_emissao'])) > 1) {
            $date = DateTime::createFromFormat('d/m/Y', $input['data_emissao']);
            $usableDate = $date->format('Y-m-d');
            $input['data_emissao'] =$usableDate;
        }

        $tesouraria = $this->tesourariaRepository->update($input, $id);

        Flash::success('Tesouraria atualizada com sucesso.');

        return redirect(route('tesourarias.index'));
    }

    /**
     * Remove the specified Tesouraria from storage.
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
                $this->tesourariaRepository->delete($id);
            }

            DB::commit();
            Flash::success('Tesouraria(s) inativada(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Tesouraria(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
