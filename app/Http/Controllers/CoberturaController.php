<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCoberturaRequest;
use App\Http\Requests\UpdateCoberturaRequest;
use App\Repositories\CoberturaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class CoberturaController extends AppBaseController
{
    /** @var  CoberturaRepository */
    private $coberturaRepository;

    public function __construct(CoberturaRepository $coberturaRepo)
    {
        $this->coberturaRepository = $coberturaRepo;
        // Set Permissions
        $this->middleware('permission:cobertura_listar', ['only' => ['index']]); 
        $this->middleware('permission:cobertura_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:cobertura_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:cobertura_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:cobertura_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Cobertura.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all(); 

        /** Titulo da página */
        $title = "Cobertura";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Cobertura";
        /** Filtros */
        $this->coberturaRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->coberturaRepository->filter($filtros);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $coberturas = $this->coberturaRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $coberturas = $this->coberturaRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $coberturas = $this->coberturaRepository->paginate();
            }
        }else{
            $coberturas = $this->coberturaRepository->paginate();
        }

        return view('coberturas.index', compact('title','breadcrumb','coberturas', 'filters'));
    }

    /**
     * Show the form for creating a new Cobertura.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Cobertura";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addCobertura";

        return view('coberturas.create', compact('title','breadcrumb'));
    }

    /**
     * Store a newly created Cobertura in storage.
     *
     * @param CreateCoberturaRequest $request
     *
     * @return Response
     */
    public function store(CreateCoberturaRequest $request)
    {
        $input = $request->all();

        $cobertura = $this->coberturaRepository->create($input);

        Flash::success('Cobertura salvo com sucesso.');

        return redirect(route('coberturas.index'));
    }

    /**
     * Display the specified Cobertura.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Cobertura";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showCobertura";
        
        $cobertura = $this->coberturaRepository->findWithoutFail($id);

        if (empty($cobertura)) {
            Flash::error('Cobertura não encontrado');

            return redirect(route('coberturas.index'));
        }

        return view('coberturas.show', compact('title','breadcrumb','cobertura'));
    }

    /**
     * Show the form for editing the specified Cobertura.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cobertura = $this->coberturaRepository->findWithoutFail($id);

        if (empty($cobertura)) {
            Flash::error('Cobertura não encontrado');

            return redirect(route('coberturas.index'));
        }

        // Titulo da página
        $title = "Cobertura";
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editCobertura";
        $breadcrumb->id = $cobertura->id;
        $breadcrumb->titulo = $cobertura->id;

        return view('coberturas.edit', compact('title','breadcrumb','cobertura'));
    }

    /**
     * Update the specified Cobertura in storage.
     *
     * @param  int              $id
     * @param UpdateCoberturaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCoberturaRequest $request)
    {
        $cobertura = $this->coberturaRepository->findWithoutFail($id);

        if (empty($cobertura)) {
            Flash::error('Cobertura não encontrado');

            return redirect(route('coberturas.index'));
        }

        $cobertura = $this->coberturaRepository->update($request->all(), $id);

        Flash::success('Cobertura atualizado com sucesso.');

        return redirect(route('coberturas.index'));
    }

    /**
     * Remove the specified Cobertura from storage.
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
                $this->coberturaRepository->delete($id);
            }

            DB::commit();
            Flash::success('Cobertura(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Cobertura(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
