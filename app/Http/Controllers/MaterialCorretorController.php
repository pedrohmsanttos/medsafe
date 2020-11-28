<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMaterialCorretorRequest;
use App\Http\Requests\UpdateMaterialCorretorRequest;
use App\Repositories\MaterialCorretorRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class MaterialCorretorController extends AppBaseController
{
    /** @var  MaterialCorretorRepository */
    private $materialCorretorRepository;

    public function __construct(MaterialCorretorRepository $materialCorretorRepo)
    {
        $this->materialCorretorRepository = $materialCorretorRepo;
        // Set Permissions
        $this->middleware('permission:materialCorretor_listar', ['only' => ['index']]);
        $this->middleware('permission:materialCorretor_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the MaterialCorretor.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all(); 

        /** Titulo da página */
        $title = "Material";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "MaterialCorretor";
        /** Filtros */
        $request = $this->setOrderBy($request);
        $this->materialCorretorRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->materialCorretorRepository->filter($filtros);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $materialCorretors = $this->materialCorretorRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $materialCorretors = $this->materialCorretorRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $materialCorretors = $this->materialCorretorRepository->paginate();
            }
        }else{
            $materialCorretors = $this->materialCorretorRepository->paginate();
        }

        return view('material_corretors.index', compact('title','breadcrumb','materialCorretors', 'filters'));
    }

    /**
     * Show the form for creating a new MaterialCorretor.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Material Corretor";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addMaterialCorretor";

        return view('material_corretors.create', compact('title','breadcrumb'));
    }

    /**
     * Store a newly created MaterialCorretor in storage.
     *
     * @param CreateMaterialCorretorRequest $request
     *
     * @return Response
     */
    public function store(CreateMaterialCorretorRequest $request)
    {
        $input = $request->all();

        $materialCorretor = $this->materialCorretorRepository->create($input);

        Flash::success('Material Corretor salvo com sucesso.');

        return redirect(route('materialCorretors.index'));
    }

    /**
     * Display the specified MaterialCorretor.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Material";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showMaterialCorretor";
        
        $materialCorretor = $this->materialCorretorRepository->findWithoutFail($id);

        if (empty($materialCorretor)) {
            Flash::error('Material Corretor não encontrado');

            return redirect(route('materialCorretors.index'));
        }

        return view('material_corretors.show', compact('title','breadcrumb','materialCorretor'));
    }

    /**
     * Show the form for editing the specified MaterialCorretor.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $materialCorretor = $this->materialCorretorRepository->findWithoutFail($id);

        if (empty($materialCorretor)) {
            Flash::error('Material Corretor não encontrado');

            return redirect(route('materialCorretors.index'));
        }

        // Titulo da página
        $title = "Material";
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editMaterialCorretor";
        $breadcrumb->id = $materialCorretor->id;
        $breadcrumb->titulo = $materialCorretor->id;

        return view('material_corretors.edit', compact('title','breadcrumb','materialCorretor'));
    }

    /**
     * Update the specified MaterialCorretor in storage.
     *
     * @param  int              $id
     * @param UpdateMaterialCorretorRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMaterialCorretorRequest $request)
    {
        $materialCorretor = $this->materialCorretorRepository->findWithoutFail($id);

        if (empty($materialCorretor)) {
            Flash::error('Material Corretor não encontrado');

            return redirect(route('materialCorretors.index'));
        }

        $materialCorretor = $this->materialCorretorRepository->update($request->all(), $id);

        Flash::success('Material Corretor atualizado com sucesso.');

        return redirect(route('materialCorretors.index'));
    }

    /**
     * Remove the specified MaterialCorretor from storage.
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
                $this->materialCorretorRepository->delete($id);
            }

            DB::commit();
            Flash::success('Material Corretor(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Material Corretor(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
