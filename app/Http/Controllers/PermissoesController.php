<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePermissoesRequest;
use App\Http\Requests\UpdatePermissoesRequest;
use App\Repositories\PermissoesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use App\Models\Permission;
use App\Models\Role;

class PermissoesController extends AppBaseController
{
    /** @var  PermissoesRepository */
    private $permissoesRepository;

    public function __construct(PermissoesRepository $permissoesRepo)
    {
        $this->permissoesRepository = $permissoesRepo;
        // Set Permissions
        $this->middleware('permission:permissoes_adicionar', ['only' => ['index','create', 'store']]);
        $this->middleware('permission:permissoes_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:permissoes_deletar', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the Permissoes.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all(); 

        /** Titulo da página */
        $title = "Permissões";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Permissoes";
        /** Filtros */
        $this->permissoesRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->permissoesRepository->filter($filtros);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $permissoes = $this->permissoesRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $permissoes = $this->permissoesRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $permissoes = $this->permissoesRepository->paginate();
            }
        }else{
            $permissoes = $this->permissoesRepository->paginate();
        }

        return view('permissoes.index', compact('title','breadcrumb','permissoes', 'filters'));
    }

    /**
     * Show the form for creating a new Permissoes.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Permissoes";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addPermissoes";

        $permissoes = new Role();
        $permissions = Permission::all();

        return view('permissoes.create', compact('title','breadcrumb','permissoes', 'permissions'));
    }

    /**
     * Store a newly created Permissoes in storage.
     *
     * @param CreatePermissoesRequest $request
     *
     * @return Response
     */
    public function store(CreatePermissoesRequest $request)
    {
        $input = $request->all();
        
        $newRole = new Role();
        $newRole->name         = $input['name'];
        $newRole->display_name = $input['display_name'];
        $newRole->description  = $input['description'];
        $newRole->save();

        $permissoes_request = json_decode($input['permissoes']);
        $ids = array_map(function($o){ return isset($o->value) ? $o->value : ""; }, $permissoes_request);
        
        $newRole->perms()->sync($ids);

        Flash::success('Permissões salvo com sucesso.');

        return redirect(route('permissoes.index'));
    }

    /**
     * Display the specified Permissoes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Permissoes";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showPermissoes";
        
        $permissoes = $this->permissoesRepository->findWithoutFail($id);

        if (empty($permissoes)) {
            Flash::error('Permissoes não encontrado');

            return redirect(route('permissoes.index'));
        }

        return view('permissoes.show', compact('title','breadcrumb','permissoes'));
    }

    /**
     * Show the form for editing the specified Permissoes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $permissoes = Role::findOrFail($id);

        if (empty($permissoes)) {
            Flash::error('Permissão não encontrado');

            return redirect(route('permissoes.index'));
        }

        // Titulo da página
        $title = "Permissão";
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editPermissoes";
        $breadcrumb->id = $permissoes->id;
        $breadcrumb->titulo = $permissoes->display_name;
        
        $permissions = Permission::all();
        $obj = $permissions[0];

        return view('permissoes.edit', compact('title','breadcrumb','permissoes','permissions'));
    }

    /**
     * Update the specified Permissoes in storage.
     *
     * @param  int              $id
     * @param UpdatePermissoesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePermissoesRequest $request)
    {
        $input      = $request->all();
        $permissoes = Role::findOrFail($id);

        if (empty($permissoes)) {
            Flash::error('Permissão não encontrado');

            return redirect(route('permissoes.index'));
        }

        $permissoes->name         = $input['name'];
        $permissoes->display_name = $input['display_name'];
        $permissoes->description  = $input['description'];
        $permissoes->save();

        if(!is_null($request->permissoes)){
            $permissoes_request = json_decode($request->permissoes);
            $ids = array_map(function($o){ return isset($o->value) ? $o->value : ""; }, $permissoes_request);

            $permissoes->perms()->sync($ids);
        }

        Flash::success('Permissão atualizado com sucesso.');

        return redirect(route('permissoes.index'));
    }

    /**
     * Remove the specified Permissoes from storage.
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
                $this->permissoesRepository->delete($id);
            }

            DB::commit();
            Flash::success('Permissão(ões) inativada(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Permissão(ões)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
