<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePerguntaRequest;
use App\Http\Requests\UpdatePerguntaRequest;
use App\Repositories\PerguntaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class PerguntaController extends AppBaseController
{
    /** @var  PerguntaRepository */
    private $perguntaRepository;

    public function __construct(PerguntaRepository $perguntaRepo)
    {
        $this->perguntaRepository = $perguntaRepo;
        // Set Permissions
        $this->middleware('permission:pergunta_listar', ['only' => ['index']]); 
        $this->middleware('permission:pergunta_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:pergunta_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:pergunta_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:pergunta_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Pergunta.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all(); 

        /** Titulo da página */
        $title = "Pergunta";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Pergunta";
        /** Filtros */
        $this->perguntaRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->perguntaRepository->filter($filtros);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $perguntas = $this->perguntaRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $perguntas = $this->perguntaRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $perguntas = $this->perguntaRepository->paginate();
            }
        }else{
            $perguntas = $this->perguntaRepository->paginate();
        }

        return view('perguntas.index', compact('title','breadcrumb','perguntas', 'filters'));
    }

    /**
     * Show the form for creating a new Pergunta.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Pergunta";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addPergunta";

        return view('perguntas.create', compact('title','breadcrumb'));
    }

    /**
     * Store a newly created Pergunta in storage.
     *
     * @param CreatePerguntaRequest $request
     *
     * @return Response
     */
    public function store(CreatePerguntaRequest $request)
    {
        $input = $request->all();

        $pergunta = $this->perguntaRepository->create($input);

        Flash::success('Pergunta salvo com sucesso.');

        return redirect(route('perguntas.index'));
    }

    /**
     * Display the specified Pergunta.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Pergunta";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showPergunta";
        
        $pergunta = $this->perguntaRepository->findWithoutFail($id);

        if (empty($pergunta)) {
            Flash::error('Pergunta não encontrado');

            return redirect(route('perguntas.index'));
        }

        return view('perguntas.show', compact('title','breadcrumb','pergunta'));
    }

    /**
     * Show the form for editing the specified Pergunta.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pergunta = $this->perguntaRepository->findWithoutFail($id);

        if (empty($pergunta)) {
            Flash::error('Pergunta não encontrado');

            return redirect(route('perguntas.index'));
        }

        // Titulo da página
        $title = "Pergunta";
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editPergunta";
        $breadcrumb->id = $pergunta->id;
        $breadcrumb->titulo = $pergunta->id;

        return view('perguntas.edit', compact('title','breadcrumb','pergunta'));
    }

    /**
     * Update the specified Pergunta in storage.
     *
     * @param  int              $id
     * @param UpdatePerguntaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePerguntaRequest $request)
    {
        $pergunta = $this->perguntaRepository->findWithoutFail($id);

        if (empty($pergunta)) {
            Flash::error('Pergunta não encontrado');

            return redirect(route('perguntas.index'));
        }

        $pergunta = $this->perguntaRepository->update($request->all(), $id);

        Flash::success('Pergunta atualizado com sucesso.');

        return redirect(route('perguntas.index'));
    }

    /**
     * Remove the specified Pergunta from storage.
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
                $this->perguntaRepository->delete($id);
            }

            DB::commit();
            Flash::success('Pergunta(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Pergunta(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
