<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCorretorRequest;
use App\Http\Requests\UpdateCorretorRequest;
use App\Repositories\CorretorRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class CorretorController extends AppBaseController
{
    /** @var  CorretorRepository */
    private $corretorRepository;

    public function __construct(CorretorRepository $corretorRepo)
    {
        $this->corretorRepository = $corretorRepo;
        // Set Permissions
        $this->middleware('permission:corretor_listar', ['only' => ['index']]); 
        $this->middleware('permission:corretor_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:corretor_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:corretor_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:corretor_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Corretor.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all(); 

        /** Titulo da página */
        $title = "Corretor";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Corretor";
        /** Filtros */
        $this->corretorRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->corretorRepository->filter($filtros);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $corretors = $this->corretorRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $corretors = $this->corretorRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $corretors = $this->corretorRepository->paginate();
            }
        }else{
            $corretors = $this->corretorRepository->paginate();
        }

        return view('corretors.index', compact('title','breadcrumb','corretors', 'filters'));
    }

    /**
     * Show the form for creating a new Corretor.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Corretor";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addCorretor";

        return view('corretors.create', compact('title','breadcrumb'));
    }

    /**
     * Store a newly created Corretor in storage.
     *
     * @param CreateCorretorRequest $request
     *
     * @return Response
     */
    public function store(CreateCorretorRequest $request)
    {
        $input = $request->all();

        $corretor = $this->corretorRepository->create($input);

        Flash::success('Corretor salvo com sucesso.');

        return redirect(route('corretors.index'));
    }

    /**
     * Display the specified Corretor.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Corretor";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showCorretor";
        
        $corretor = $this->corretorRepository->findWithoutFail($id);

        if (empty($corretor)) {
            Flash::error('Corretor não encontrado');

            return redirect(route('corretors.index'));
        }

        return view('corretors.show', compact('title','breadcrumb','corretor'));
    }

    /**
     * Show the form for editing the specified Corretor.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $corretor = $this->corretorRepository->findWithoutFail($id);

        if (empty($corretor)) {
            Flash::error('Corretor não encontrado');

            return redirect(route('corretors.index'));
        }

        // Titulo da página
        $title = "Corretor";
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editCorretor";
        $breadcrumb->id = $corretor->id;
        $breadcrumb->titulo = $corretor->id;

        return view('corretors.edit', compact('title','breadcrumb','corretor'));
    }

    /**
     * Update the specified Corretor in storage.
     *
     * @param  int              $id
     * @param UpdateCorretorRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCorretorRequest $request)
    {
        $corretor = $this->corretorRepository->findWithoutFail($id);

        if (empty($corretor)) {
            Flash::error('Corretor não encontrado');

            return redirect(route('corretors.index'));
        }

        $corretor = $this->corretorRepository->update($request->all(), $id);

        Flash::success('Corretor atualizado com sucesso.');

        return redirect(route('corretors.index'));
    }

    /**
     * Remove the specified Corretor from storage.
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
                $this->corretorRepository->delete($id);
            }

            DB::commit();
            Flash::success('Corretor(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Corretor(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
