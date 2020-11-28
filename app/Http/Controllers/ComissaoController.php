<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateComissaoRequest;
use App\Http\Requests\UpdateComissaoRequest;
use App\Repositories\ComissaoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use App\Models\LancamentoPagar;

class ComissaoController extends AppBaseController
{
    /** @var  ComissaoRepository */
    private $comissaoRepository;

    public function __construct(ComissaoRepository $comissaoRepo)
    {
        $this->comissaoRepository = $comissaoRepo;
        // Set Permissions
        $this->middleware('permission:comissao_listar', ['only' => ['index']]); 
        $this->middleware('permission:comissao_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:comissao_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:comissao_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:comissao_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Comissao.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all(); 

        /** Titulo da página */
        $title = "Comissão";
        
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Comissao";
        /** Filtros */
        $request = $this->setOrderBy($request);
        $this->comissaoRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->comissaoRepository->filter($filtros);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $comissaos = $this->comissaoRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $comissaos = $this->comissaoRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $comissaos = $this->comissaoRepository->paginate();
            }
        }else{
            $comissaos = $this->comissaoRepository->paginate();
        }

        return view('comissaos.index', compact('title','breadcrumb','comissaos', 'filters'));
    }

    /**
     * Show the form for creating a new Comissao.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Comissão";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addComissao";

        return view('comissaos.create', compact('title','breadcrumb'));
    }

    /**
     * Store a newly created Comissao in storage.
     *
     * @param CreateComissaoRequest $request
     *
     * @return Response
     */
    public function store(CreateComissaoRequest $request)
    {
        $input = $request->all();

        $comissao = $this->comissaoRepository->create($input);

        Flash::success('Comissao salvo com sucesso.');

        return redirect(route('comissaos.index'));
    }

    /**
     * Display the specified Comissao.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Comissão";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showComissao";
        
        $comissao = $this->comissaoRepository->findWithoutFail($id);

        if (empty($comissao)) {
            Flash::error('Comissao não encontrado');

            return redirect(route('comissaos.index'));
        }

        return view('comissaos.show', compact('title','breadcrumb','comissao'));
    }

    /**
     * Show the form for editing the specified Comissao.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $comissao = $this->comissaoRepository->findWithoutFail($id);

        if (empty($comissao)) {
            Flash::error('Comissao não encontrado');

            return redirect(route('comissaos.index'));
        }

        // Titulo da página
        $title = "Comissão";
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editComissao";
        $breadcrumb->id = $comissao->id;
        $breadcrumb->titulo = $comissao->id;

        return view('comissaos.edit', compact('title','breadcrumb','comissao'));
    }

    /**
     * Update the specified Comissao in storage.
     *
     * @param  int              $id
     * @param UpdateComissaoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateComissaoRequest $request)
    {
        $comissao = $this->comissaoRepository->findWithoutFail($id);
        $input = $request->all();

        if (empty($comissao)) {
            Flash::error('Comissao não encontrado');

            return redirect(route('comissaos.index'));
        }

        if( $comissao->status_aprovacao == 'aprovado' ){
            Flash::error('Essa comissão já foi aprovada e não pode ser alterada');
            return redirect(route('comissaos.index'));
        }
        $comissao->status_aprovacao = $input['status_aprovacao'];
        $comissao->save();
        if($input['status_aprovacao'] == 'aprovado'){
            date_default_timezone_set('America/Recife');
            $lancamento = new LancamentoPagar();
            $dataVencimento = $lancamento->calculaVencimentoComissao($comissao->corretor()->first()->periodo_de_pagamento);
            $lancamento->data_vencimento = $dataVencimento;
            $lancamento->data_emissao = date('Y-m-d', time());
            $lancamento->valor_titulo = $comissao->comissao;
            $lancamento->corretor_id = $comissao->corretor_id;
            $lancamento->numero_documento = '0000';
            $lancamento->save();
            


        }
        //$comissao = $this->comissaoRepository->update($request->all(), $id);

        Flash::success('Comissão atualizado com sucesso.');

        return redirect(route('comissaos.index'));
    }

    /**
     * Remove the specified Comissao from storage.
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
        try{
            foreach ($ids as $id) {
                $this->comissaoRepository->delete($id);
            }

            DB::commit();
            Flash::success('Comissao(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Comissao(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }

    public function setOrderBy(Request $request)
    {
        $input = $request->all();
        if (empty($input['orderBy'])) {
            $request->attributes->add(['orderBy' => 'status_aprovacao']);
            $request->attributes->add(['sortedBy' => 'asc']);
        }
        
        return $request;
    }
}
