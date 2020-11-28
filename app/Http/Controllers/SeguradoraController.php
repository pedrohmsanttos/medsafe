<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSeguradoraRequest;
use App\Http\Requests\UpdateSeguradoraRequest;
use App\Repositories\SeguradoraRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class SeguradoraController extends AppBaseController
{
    /** @var  SeguradoraRepository */
    private $seguradoraRepository;

    public function __construct(SeguradoraRepository $seguradoraRepo)
    {
        $this->seguradoraRepository = $seguradoraRepo;
        // Set Permissions
        $this->middleware('permission:seguradoras_listar', ['only' => ['index']]); 
        $this->middleware('permission:seguradoras_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:seguradoras_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:seguradoras_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:seguradoras_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Seguradora.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all(); 
        $this->seguradoraRepository->pushCriteria(new RequestCriteria($request));
        // $seguradoras = $this->seguradoraRepository->all();

         /** Titulo da página */
         $title = "Seguradora";
         /** Breadcrumb */
         $breadcrumb = new \stdClass;
         $breadcrumb->nome = "seguradora";

        $filters = $this->seguradoraRepository->filter($filtros);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $seguradoras = $this->seguradoraRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $seguradoras = $this->seguradoraRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $seguradoras = $this->seguradoraRepository->paginate();
            }
        }else{
            $seguradoras = $this->seguradoraRepository->paginate();
        }

         return view('seguradoras.index', compact('title','breadcrumb','seguradoras', 'filters'));

        
    }

    /**
     * Show the form for creating a new Seguradora.
     *
     * @return Response
     */
    public function create()
    {

        /** Titulo da página */
        $title = "Adicionar Seguradora";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addSeguradora";
        return view('seguradoras.create', compact('title','breadcrumb'));
    }

    /**
     * Store a newly created Seguradora in storage.
     *
     * @param CreateSeguradoraRequest $request
     *
     * @return Response
     */
    public function store(CreateSeguradoraRequest $request)
    {
        $input = $request->all();

        $seguradora = $this->seguradoraRepository->create($input);

        Flash::success('Seguradora cadastrada com sucesso.');

        return redirect(route('seguradoras.index'));
    }

    /**
     * Display the specified Seguradora.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $seguradora = $this->seguradoraRepository->findWithoutFail($id);

        if (empty($seguradora)) {
            Flash::error('Seguradora não encontrada');

            return redirect(route('seguradoras.index'));
        }

        return view('seguradoras.show')->with('seguradora', $seguradora);
    }

    /**
     * Show the form for editing the specified Seguradora.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $seguradora  = $this->seguradoraRepository->findWithoutFail($id);
        
        if (empty($seguradora)) {
            Flash::error('Seguradora não encontrada!');

            return redirect(route('seguradoras.index'));
        }


        // Titulo da página
        $title = "Editar: ". $seguradora->descricaoCorretor;
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editSeguradora";
        $breadcrumb->id = $seguradora->id;
        $breadcrumb->titulo = $seguradora->descricaoCorretor;

        return view('seguradoras.edit', compact('title','breadcrumb','seguradora'));


    }

    /**
     * Update the specified Seguradora in storage.
     *
     * @param  int              $id
     * @param UpdateSeguradoraRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSeguradoraRequest $request)
    {
        $seguradora = $this->seguradoraRepository->findWithoutFail($id);

        if (empty($seguradora)) {
            Flash::error('Seguradora not found');

            return redirect(route('seguradoras.index'));
        }

        $seguradora = $this->seguradoraRepository->update($request->all(), $id);

        Flash::success('Seguradora atualizada com sucesso.');

        return redirect(route('seguradoras.index'));
    }

    /**
     * Remove the specified Seguradora from storage.
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
                $this->seguradoraRepository->delete($id);
            }

            DB::commit();
            Flash::success('Seguradora(s) inativada(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Seguradora!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
