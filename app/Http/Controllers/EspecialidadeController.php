<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEspecialidadeRequest;
use App\Http\Requests\UpdateEspecialidadeRequest;
use App\Repositories\EspecialidadeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Especialidade;
use App\Models\Cliente;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class EspecialidadeController extends AppBaseController
{
    /** @var  EspecialidadeRepository */
    private $especialidadeRepository;

    public function __construct(EspecialidadeRepository $especialidadeRepo)
    {
        $this->especialidadeRepository = $especialidadeRepo;
        // Set Permissions
        $this->middleware('permission:especialidade_listar', ['only' => ['index']]); 
        $this->middleware('permission:especialidade_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:especialidade_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:especialidade_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:especialidade_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Especialidade.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all(); 

        /** Titulo da página */
        $title = "Especialidade";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Especialidade";
        /** Filtros */
        $this->especialidadeRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->especialidadeRepository->filter($filtros);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $especialidades = $this->especialidadeRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $especialidades = $this->especialidadeRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $especialidades = $this->especialidadeRepository->paginate();
            }
        }else{
            $especialidades = $this->especialidadeRepository->paginate();
        }

        return view('especialidades.index', compact('title','breadcrumb','especialidades', 'filters'));
    }

    /**
     * Show the form for creating a new Especialidade.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Especialidade";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addEspecialidade";

        return view('especialidades.create', compact('title','breadcrumb'));
    }

    /**
     * Store a newly created Especialidade in storage.
     *
     * @param CreateEspecialidadeRequest $request
     *
     * @return Response
     */
    public function store(CreateEspecialidadeRequest $request)
    {
        $input = $request->all();

        $especialidade = $this->especialidadeRepository->create($input);

        Flash::success('Especialidade salvo com sucesso.');

        return redirect(route('especialidades.index'));
    }

    /**
     * Display the specified Especialidade.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Especialidade";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showEspecialidade";
        
        $especialidade = $this->especialidadeRepository->findWithoutFail($id);

        if (empty($especialidade)) {
            Flash::error('Especialidade não encontrado');

            return redirect(route('especialidades.index'));
        }

        return view('especialidades.show', compact('title','breadcrumb','especialidade'));
    }

    /**
     * Show the form for editing the specified Especialidade.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $especialidade = $this->especialidadeRepository->findWithoutFail($id);

        if (empty($especialidade)) {
            Flash::error('Especialidade não encontrado');

            return redirect(route('especialidades.index'));
        }

        // Titulo da página
        $title = "Especialidade";
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editEspecialidade";
        $breadcrumb->id = $especialidade->id;
        $breadcrumb->titulo = $especialidade->id;

        return view('especialidades.edit', compact('title','breadcrumb','especialidade'));
    }

    /**
     * Update the specified Especialidade in storage.
     *
     * @param  int              $id
     * @param UpdateEspecialidadeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEspecialidadeRequest $request)
    {
        $especialidade = $this->especialidadeRepository->findWithoutFail($id);

        if (empty($especialidade)) {
            Flash::error('Especialidade não encontrado');

            return redirect(route('especialidades.index'));
        }

        $especialidade = $this->especialidadeRepository->update($request->all(), $id);

        Flash::success('Especialidade atualizado com sucesso.');

        return redirect(route('especialidades.index'));
    }

    /**
     * Remove the specified Especialidade from storage.
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
                $especialidade = Especialidade::find($id);
                $clientes = Cliente::where('especialidade_id',$id)->get();
                
                if(count($clientes ) == 0){
                    $this->especialidadeRepository->delete($id);
                } else{
                    $itensProibidos .= $especialidade->descricao.",";
                }
            }

            if( strlen($itensProibidos) > 0){
                $itensProibidos = substr($itensProibidos, 0, -1);
                DB::commit();
                Flash::error('As especialidade(s): "'.$itensProibidos. '" não podem ser inativadas porque são utilizados em outras partes do sistema.');
                return response()->json([
                    'msg' => 'Sucesso'
                ]);
            }

            DB::commit();
            Flash::success('Especialidade(s) inativada(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Especialidade(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
