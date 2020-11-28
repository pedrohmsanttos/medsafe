<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Repositories\MaterialRepository;
use App\Repositories\MaterialItemRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\MaterialItem;
use App\Models\Material;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class MaterialController extends AppBaseController
{
    /** @var  MaterialRepository */
    private $materialRepository;

    /** @var  MaterialItemRepository */
    private $materialItemRepository;

    public function __construct(
        MaterialRepository $materialRepo,
        MaterialItemRepository $materialItemRepo
        )
    {
        $this->materialRepository = $materialRepo;
        $this->materialItemRepository = $materialItemRepo;
        //Set Permissions
        $this->middleware('permission:material_listar', ['only' => ['index']]); 
        $this->middleware('permission:material_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:material_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:material_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:material_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Material.
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
        $breadcrumb->nome = "Material";
        /** Filtros */
        $request = $this->setOrderBy($request);
        $this->materialRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->materialRepository->filter($filtros);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $materials = $this->materialRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $materials = $this->materialRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $materials = $this->materialRepository->paginate();
            }
        }else{
            $materials = $this->materialRepository->paginate();
        }

        return view('materials.index', compact('title','breadcrumb','materials', 'filters'));
    }

    /**
     * Show the form for creating a new Material.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Material";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addMaterial";

        return view('materials.create', compact('title','breadcrumb'));
    }

    /**
     * Store a newly created Material in storage.
     *
     * @param CreateMaterialRequest $request
     *
     * @return Response
     */
    public function store(CreateMaterialRequest $request)
    {
        $input = $request->all();
        $inputMaterial = $request->all();
        $validaArquivos = true;
        if ($request->hasFile('arquivo')) {

            foreach($request->file('arquivo') as $arquivo){
                if(!$arquivo->isValid()){
                    $validaArquivos = false;
                }
            }
            unset($inputMaterial['arquivo']);
            $material = $this->materialRepository->create($inputMaterial);

            if($validaArquivos){

                foreach(request()->arquivo as $i => $arquivo){
                    $nameFile = "material_".time().$i.'.'.$arquivo->getClientOriginalExtension();
                    // Faz o upload na pasta:
                    $upload = $request->arquivo[$i]->storeAs('materials', $nameFile);
                    
                    // Verifica se NÃO deu certo o upload (Redireciona de volta)
                    if ( !$upload ){
                        return redirect()->back()->with('error', 'Falha ao fazer upload')->withInput();
                    }
                    $materialItem = new MaterialItem();
                    $materialItem->material_id = $material->id;
                    $materialItem->arquivo =  $upload;
                    $materialItem->save();
                }
        
                }
        }

        Flash::success('Material salvo com sucesso.');

        return redirect(route('materials.index'));
    }

    /**
     * Display the specified Material.
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
        $breadcrumb->nome = "showMaterial";
        
        $material = $this->materialRepository->findWithoutFail($id);

        if (empty($material)) {
            Flash::error('Material não encontrado');

            return redirect(route('materials.index'));
        }

        return view('materials.show', compact('title','breadcrumb','material'));
    }

    /**
     * Show the form for editing the specified Material.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $material = $this->materialRepository->findWithoutFail($id);

        

        if (empty($material)) {
            Flash::error('Material não encontrado');

            return redirect(route('materials.index'));
        }

        // Titulo da página
        $title = "Material";
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editMaterial";
        $breadcrumb->id = $material->id;
        $breadcrumb->titulo = $material->id;

        //dd($material);

        return view('materials.edit', compact('title','breadcrumb','material'));
    }

    public function deletar($idMaterial,$id)
    {
        $arquivos = MaterialItem::where('material_id',$idMaterial)->get();
        if(count($arquivos) > 1){
            $this->materialItemRepository->delete($id);
            Flash::success('Material atualizado com sucesso.');
            return redirect('materials/'.$idMaterial.'/edit');
        } 
        Flash::error('Um material não pode ficar sem arquivos');

        return redirect(route('materials.index'));

        if (empty($material)) {
            Flash::error('Material não encontrado');

            return redirect(route('materials.index'));
        }

        // Titulo da página
        $title = "Material";
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "deleteMaterial";

        return view('materials.edit', compact('title','breadcrumb','material'));
    }

    /**
     * Update the specified Material in storage.
     *
     * @param  int              $id
     * @param UpdateMaterialRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMaterialRequest $request)
    {
        $material = $this->materialRepository->findWithoutFail($id);
        $input = $request->all();
        $validaArquivos = true;
        if ($request->hasFile('arquivo')) {

            foreach($request->file('arquivo') as $arquivo){
                if(!$arquivo->isValid()){
                    $validaArquivos = false;
                }
            }

            if($validaArquivos){

                foreach(request()->arquivo as $i => $arquivo){
                    $nameFile = "material_".time().$i.'.'.$arquivo->getClientOriginalExtension();
                    // Faz o upload na pasta:
                    $upload = $request->arquivo[$i]->storeAs('materials', $nameFile);
                    
                    // Verifica se NÃO deu certo o upload (Redireciona de volta)
                    if ( !$upload ){
                        return redirect()->back()->with('error', 'Falha ao fazer upload')->withInput();
                    }
                    $materialItem = new MaterialItem();
                    $materialItem->material_id = $material->id;
                    $materialItem->arquivo =  $upload;
                    $materialItem->save();
                }
        
                }
        } 
        unset($input['arquivo']);
        $material = $this->materialRepository->update($input, $id);

        Flash::success('Material atualizado com sucesso.');

        return redirect(route('materials.index'));
    }

    /**
     * Remove the specified Material from storage.
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
                $this->materialRepository->delete($id);
            }

            DB::commit();
            Flash::success('Material(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Material(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
