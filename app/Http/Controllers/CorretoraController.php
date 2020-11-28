<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCorretoraRequest;
use App\Http\Requests\UpdateCorretoraRequest;
use App\Repositories\CorretoraRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class CorretoraController extends AppBaseController
{
    /** @var  CorretoraRepository */
    private $corretoraRepository;

    public function __construct(CorretoraRepository $corretoraRepo)
    {
        $this->corretoraRepository = $corretoraRepo;
        // Set Permissions
        $this->middleware('permission:corretora_listar', ['only' => ['index']]); 
        $this->middleware('permission:corretora_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:corretora_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:corretora_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:corretora_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Corretora.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all(); 

        /** Titulo da página */
        $title = "Corretora";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Corretora";
        /** Filtros */
        $this->corretoraRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->corretoraRepository->filter($filtros);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $corretoras = $this->corretoraRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $corretoras = $this->corretoraRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $corretoras = $this->corretoraRepository->paginate();
            }
        }else{
            $corretoras = $this->corretoraRepository->paginate();
        }

        return view('corretoras.index', compact('title','breadcrumb','corretoras', 'filters'));
    }

    /**
     * Show the form for creating a new Corretora.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Corretora";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addCorretora";

        return view('corretoras.create', compact('title','breadcrumb'));
    }

    /**
     * Store a newly created Corretora in storage.
     *
     * @param CreateCorretoraRequest $request
     *
     * @return Response
     */
    public function store(CreateCorretoraRequest $request)
    {
        $input = $request->all();

        $corretora = $this->corretoraRepository->create($input);

        Flash::success('Corretora salvo com sucesso.');

        return redirect(route('corretoras.index'));
    }

    /**
     * Display the specified Corretora.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Corretora";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showCorretora";
        
        $corretora = $this->corretoraRepository->findWithoutFail($id);

        if (empty($corretora)) {
            Flash::error('Corretora não encontrado');

            return redirect(route('corretoras.index'));
        }

        return view('corretoras.show', compact('title','breadcrumb','corretora'));
    }

    /**
     * Show the form for editing the specified Corretora.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $corretora = $this->corretoraRepository->findWithoutFail($id);

        if (empty($corretora)) {
            Flash::error('Corretora não encontrado');

            return redirect(route('corretoras.index'));
        }

        // Titulo da página
        $title = "Corretora";
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editCorretora";
        $breadcrumb->id = $corretora->id;
        $breadcrumb->titulo = $corretora->id;

        return view('corretoras.edit', compact('title','breadcrumb','corretora'));
    }

    /**
     * Update the specified Corretora in storage.
     *
     * @param  int              $id
     * @param UpdateCorretoraRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCorretoraRequest $request)
    {
        $corretora = $this->corretoraRepository->findWithoutFail($id);

        if (empty($corretora)) {
            Flash::error('Corretora não encontrado');

            return redirect(route('corretoras.index'));
        }

        $corretora = $this->corretoraRepository->update($request->all(), $id);

        Flash::success('Corretora atualizado com sucesso.');

        return redirect(route('corretoras.index'));
    }

    /**
     * Remove the specified Corretora from storage.
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
                $this->corretoraRepository->delete($id);
            }

            DB::commit();
            Flash::success('Corretora(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Corretora(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
