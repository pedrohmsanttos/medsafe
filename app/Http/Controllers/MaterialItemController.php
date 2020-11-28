<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMaterialItemRequest;
use App\Http\Requests\UpdateMaterialItemRequest;
use App\Repositories\MaterialItemRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class MaterialItemController extends AppBaseController
{
    /** @var  MaterialItemRepository */
    private $materialItemRepository;

    public function __construct(MaterialItemRepository $materialItemRepo)
    {
        $this->materialItemRepository = $materialItemRepo;
        // Set Permissions
        $this->middleware('permission:materialItem_listar', ['only' => ['index']]); 
        $this->middleware('permission:materialItem_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:materialItem_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:materialItem_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:materialItem_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the MaterialItem.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all(); 

        /** Titulo da página */
        $title = "Material Item";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Material Item";
        /** Filtros */
        $this->materialItemRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->materialItemRepository->filter($filtros);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $materialItems = $this->materialItemRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $materialItems = $this->materialItemRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $materialItems = $this->materialItemRepository->paginate();
            }
        }else{
            $materialItems = $this->materialItemRepository->paginate();
        }

        return view('material_items.index', compact('title','breadcrumb','materialItems', 'filters'));
    }

    /**
     * Show the form for creating a new MaterialItem.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Material Item";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addMaterial Item";

        return view('material_items.create', compact('title','breadcrumb'));
    }

    /**
     * Store a newly created MaterialItem in storage.
     *
     * @param CreateMaterialItemRequest $request
     *
     * @return Response
     */
    public function store(CreateMaterialItemRequest $request)
    {
        $input = $request->all();

        $materialItem = $this->materialItemRepository->create($input);

        Flash::success('Material Item salvo com sucesso.');

        return redirect(route('materialItems.index'));
    }

    /**
     * Display the specified MaterialItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Material Item";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showMaterial Item";
        
        $materialItem = $this->materialItemRepository->findWithoutFail($id);

        if (empty($materialItem)) {
            Flash::error('Material Item não encontrado');

            return redirect(route('materialItems.index'));
        }

        return view('material_items.show', compact('title','breadcrumb','materialItem'));
    }

    /**
     * Show the form for editing the specified MaterialItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $materialItem = $this->materialItemRepository->findWithoutFail($id);

        if (empty($materialItem)) {
            Flash::error('Material Item não encontrado');

            return redirect(route('materialItems.index'));
        }

        // Titulo da página
        $title = "Material Item";
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editMaterial Item";
        $breadcrumb->id = $materialItem->id;
        $breadcrumb->titulo = $materialItem->id;

        return view('material_items.edit', compact('title','breadcrumb','materialItem'));
    }

    /**
     * Update the specified MaterialItem in storage.
     *
     * @param  int              $id
     * @param UpdateMaterialItemRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMaterialItemRequest $request)
    {
        $materialItem = $this->materialItemRepository->findWithoutFail($id);

        if (empty($materialItem)) {
            Flash::error('Material Item não encontrado');

            return redirect(route('materialItems.index'));
        }

        $materialItem = $this->materialItemRepository->update($request->all(), $id);

        Flash::success('Material Item atualizado com sucesso.');

        return redirect(route('materialItems.index'));
    }

    /**
     * Remove the specified MaterialItem from storage.
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
                $this->materialItemRepository->delete($id);
            }

            DB::commit();
            Flash::success('Material Item(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Material Item(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
