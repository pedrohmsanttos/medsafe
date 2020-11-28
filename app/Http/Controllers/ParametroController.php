<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateParametroRequest;
use App\Http\Requests\UpdateParametroRequest;
use App\Repositories\ParametroRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class ParametroController extends AppBaseController
{
    /** @var  ParametroRepository */
    private $parametroRepository;

    public function __construct(ParametroRepository $parametroRepo)
    {
        $this->parametroRepository = $parametroRepo;
        // Set Permissions
        $this->middleware('permission:parametro_listar', ['only' => ['index']]); 
        $this->middleware('permission:parametro_editar', ['only' => ['edit']]);
        $this->middleware('permission:parametro_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Parametro.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all(); 

        /** Titulo da página */
        $title = "Parâmetro";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Parametro";
        /** Filtros */
        $this->parametroRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->parametroRepository->filter($filtros);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $parametros = $this->parametroRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $parametros = $this->parametroRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $parametros = $this->parametroRepository->paginate();
            }
        }else{
            $parametros = $this->parametroRepository->paginate();
        }

        return view('parametros.index', compact('title','breadcrumb','parametros', 'filters'));
    }

    /**
     * Show the form for creating a new Parametro.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Parâmetro";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addParametro";

        return view('parametros.create', compact('title','breadcrumb'));
    }

    /**
     * Store a newly created Parametro in storage.
     *
     * @param CreateParametroRequest $request
     *
     * @return Response
     */
    public function store(CreateParametroRequest $request)
    {
        $input = $request->all();

        $parametro = $this->parametroRepository->create($input);

        Flash::success('Parametro salvo com sucesso.');

        return redirect(route('parametros.index'));
    }

    /**
     * Display the specified Parametro.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Parâmetro";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showParametro";
        
        $parametro = $this->parametroRepository->findWithoutFail($id);

        if (empty($parametro)) {
            Flash::error('Parametro não encontrado');

            return redirect(route('parametros.index'));
        }

        return view('parametros.show', compact('title','breadcrumb','parametro'));
    }

    /**
     * Show the form for editing the specified Parametro.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $parametro = $this->parametroRepository->findWithoutFail($id);

        if (empty($parametro)) {
            Flash::error('Parametro não encontrado');

            return redirect(route('parametros.index'));
        }

        // Titulo da página
        $title = "Parâmetro";
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editParametro";
        $breadcrumb->id = $parametro->id;
        $breadcrumb->titulo = $parametro->id;

        return view('parametros.edit', compact('title','breadcrumb','parametro'));
    }

    /**
     * Update the specified Parametro in storage.
     *
     * @param  int              $id
     * @param UpdateParametroRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateParametroRequest $request)
    {
        $parametro = $this->parametroRepository->findWithoutFail($id);

        if (empty($parametro)) {
            Flash::error('Parametro não encontrado');

            return redirect(route('parametros.index'));
        }

        $parametro = $this->parametroRepository->update($request->all(), $id);

        Flash::success('Parametro atualizado com sucesso.');

        return redirect(route('parametros.index'));
    }

    /**
     * Remove the specified Parametro from storage.
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
                $this->parametroRepository->delete($id);
            }

            DB::commit();
            Flash::success('Parametro(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Parametro(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
