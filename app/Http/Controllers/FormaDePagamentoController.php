<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFormaDePagamentoRequest;
use App\Http\Requests\UpdateFormaDePagamentoRequest;
use App\Repositories\FormaDePagamentoRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Tesouraria;
use App\Models\FormaDePagamento;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class FormaDePagamentoController extends AppBaseController
{
    /** @var  FormaDePagamentoRepository */
    private $formaDePagamentoRepository;

    public function __construct(FormaDePagamentoRepository $formaDePagamentoRepo)
    {
        $this->formaDePagamentoRepository = $formaDePagamentoRepo;
        // Set Permissions
        $this->middleware('permission:forma_pagamentos_listar', ['only' => ['index']]); 
        $this->middleware('permission:forma_pagamentos_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:forma_pagamentos_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:forma_pagamentos_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:forma_pagamentos_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the FormaDePagamento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        
        /** Titulo da página */
        $title = "Formas de Pagamento";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "formasDePagamento";


        $filtros = $request->all(); 
        $filters = $this->formaDePagamentoRepository->filter($filtros);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $formaDePagamentos = $this->formaDePagamentoRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $formaDePagamentos = $this->formaDePagamentoRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $formaDePagamentos = $this->formaDePagamentoRepository->paginate();
            }
        }else{
            $formaDePagamentos = $this->formaDePagamentoRepository->paginate();
        }

        return view('forma_de_pagamentos.index', compact('title','breadcrumb','formaDePagamentos', 'filters'));
    }

    /**
     * Show the form for creating a new FormaDePagamento.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Adicionar Forma de Pagamento";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addFormaDePagamento";
        return view('forma_de_pagamentos.create', compact('title','breadcrumb'));

    }

    /**
     * Store a newly created FormaDePagamento in storage.
     *
     * @param CreateFormaDePagamentoRequest $request
     *
     * @return Response
     */
    public function store(CreateFormaDePagamentoRequest $request)
    {
        $input = $request->all();

        $formaDePagamento = $this->formaDePagamentoRepository->create($input);

        Flash::success('Forma De Pagamento cadastrada com sucesso.');

        return redirect(route('formaDePagamentos.index'));
    }

    /**
     * Display the specified FormaDePagamento.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $formaDePagamento = $this->formaDePagamentoRepository->findWithoutFail($id);

        if (empty($formaDePagamento)) {
            Flash::error('Forma de Pagamento não encontrado!');

            return redirect(route('formaDePagamentos.index'));
        }

        return view('forma_de_pagamentos.show')->with('formaDePagamento', $formaDePagamento);
    }

    /**
     * Show the form for editing the specified FormaDePagamento.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        
        $formaDePagamento  = $this->formaDePagamentoRepository->findWithoutFail($id);
        
        if (empty($formaDePagamento)) {
            Flash::error('Forma de Pagamento não encontrado!');

            return redirect(route('formaDePagamentos.index'));
        }

        // Titulo da página
        $title = "Editar: ". $formaDePagamento->titulo;
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editFormasDePagamento";
        $breadcrumb->id = $formaDePagamento->id;
        $breadcrumb->titulo = $formaDePagamento->titulo;

        return view('forma_de_pagamentos.edit', compact('title','breadcrumb','formaDePagamento'));

    }

    /**
     * Update the specified FormaDePagamento in storage.
     *
     * @param  int              $id
     * @param UpdateFormaDePagamentoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFormaDePagamentoRequest $request)
    {
        $formaDePagamento = $this->formaDePagamentoRepository->findWithoutFail($id);

        if (empty($formaDePagamento)) {
            Flash::error('Forma de Pagamento não encontrado!');

            return redirect(route('formaDePagamentos.index'));
        }

        $formaDePagamento = $this->formaDePagamentoRepository->update($request->all(), $id);

        Flash::success('Forma De Pagamento atualizado com sucesso.');

        return redirect(route('formaDePagamentos.index'));
    }

    /**
     * Remove the specified FormaDePagamento from storage.
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
            $itensProibidos = "";
            foreach ($ids as $id) {
                $formaPagamento = FormaDePagamento::find($id);
                $tesourarias = Tesouraria::where('formas_de_pagamento_id',$id)->get();
                if(count($tesourarias ) == 0){
                    $this->formaDePagamentoRepository->delete($id);
                } else{
                    $itensProibidos .= $formaPagamento->titulo.",";
                }
            }
            if( strlen($itensProibidos) > 0){
                $itensProibidos = substr($itensProibidos, 0, -1);
                DB::commit();
                Flash::error('As Formas de Pagamento(s): "'.$itensProibidos. '" não podem ser inativadas porque são utilizadas em outras partes do sistema.');
                return response()->json([
                    'msg' => 'Sucesso'
                ]);
            }
            DB::commit();
            Flash::success('Formas de Pagamento(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Formas de Pagamento!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
