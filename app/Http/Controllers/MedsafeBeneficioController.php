<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMedsafeBeneficioRequest;
use App\Http\Requests\UpdateMedsafeBeneficioRequest;
use App\Repositories\MedsafeBeneficioRepository;
use App\Repositories\ProdutosRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Produtos;

use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class MedsafeBeneficioController extends AppBaseController
{
    /** @var  MedsafeBeneficioRepository */
    private $medsafeBeneficioRepository;

    /** @var  ProdutosRepository */
    private $produtoRepository;

    public function __construct(
        MedsafeBeneficioRepository $medsafeBeneficioRepo,
        ProdutosRepository $produtoRepo
        )
    {
        $this->medsafeBeneficioRepository = $medsafeBeneficioRepo;
        $this->produtoRepository = $produtoRepo;
        //Set Permissions
        $this->middleware('permission:medsafeBeneficio_listar', ['only' => ['index']]); 
        $this->middleware('permission:medsafeBeneficio_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:medsafeBeneficio_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:medsafeBeneficio_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:medsafeBeneficio_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the MedsafeBeneficio.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all(); 

        /** Titulo da página */
        $title = "Benefício MEDSafer";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Benefícios MEDSafer";
        $produtos = $this->produtoRepository->all();
        $request = $this->setOrderBy($request);
        /** Filtros */
        $this->medsafeBeneficioRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->medsafeBeneficioRepository->filter($filtros);
        $nomeProduto = "";
        if(isset($filters[0]->campo) && $filters[0]->campo == 'Produto'){
            $nomeProduto = Produtos::find($filters[0]->valor)->descricao;
            
        }
        //dd($filters);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $medsafeBeneficios = $this->medsafeBeneficioRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $medsafeBeneficios = $this->medsafeBeneficioRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $medsafeBeneficios = $this->medsafeBeneficioRepository->paginate();
            }
        }else{
            $medsafeBeneficios = $this->medsafeBeneficioRepository->paginate();
        }

        return view('medsafe_beneficios.index', compact('nomeProduto','title','breadcrumb','medsafeBeneficios','produtos', 'filters'));
    }

    /**
     * Show the form for creating a new MedsafeBeneficio.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Benefício MEDSafer";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addBeneficios";

        $medsafeBeneficio = new \App\Models\MedsafeBeneficio;
        $medsafeBeneficio->produto_id ="";

        $produtos = $this->produtoRepository->orderBy('descricao')->all();

        return view('medsafe_beneficios.create', compact('title','breadcrumb','medsafeBeneficio','produtos'));
    }

    /**
     * Store a newly created MedsafeBeneficio in storage.
     *
     * @param CreateMedsafeBeneficioRequest $request
     *
     * @return Response
     */
    public function store(CreateMedsafeBeneficioRequest $request)
    {
        $input = $request->all();

        $medsafeBeneficio = $this->medsafeBeneficioRepository->create($input);

        Flash::success('Medsafe Beneficio salvo com sucesso.');

        return redirect(route('medsafeBeneficios.index'));
    }

    /**
     * Display the specified MedsafeBeneficio.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Benefício MEDSafer";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showBeneficios";
        
        $medsafeBeneficio = $this->medsafeBeneficioRepository->findWithoutFail($id);

        if (empty($medsafeBeneficio)) {
            Flash::error('Medsafe Beneficio não encontrado');

            return redirect(route('medsafeBeneficios.index'));
        }

        return view('medsafe_beneficios.show', compact('title','breadcrumb','medsafeBeneficio'));
    }

    /**
     * Show the form for editing the specified MedsafeBeneficio.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $medsafeBeneficio = $this->medsafeBeneficioRepository->findWithoutFail($id);

        if (empty($medsafeBeneficio)) {
            Flash::error('Medsafe Beneficio não encontrado');

            return redirect(route('medsafeBeneficios.index'));
        }

        // Titulo da página
        $title = "Benefício MEDSafer";
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editBeneficios";
        $breadcrumb->id = $medsafeBeneficio->id;
        $breadcrumb->titulo = $medsafeBeneficio->id;
        $produtos = $this->produtoRepository->orderBy('descricao')->all();

        return view('medsafe_beneficios.edit', compact('title','breadcrumb','medsafeBeneficio','produtos'));
    }

    /**
     * Update the specified MedsafeBeneficio in storage.
     *
     * @param  int              $id
     * @param UpdateMedsafeBeneficioRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMedsafeBeneficioRequest $request)
    {
        $medsafeBeneficio = $this->medsafeBeneficioRepository->findWithoutFail($id);

        if (empty($medsafeBeneficio)) {
            Flash::error('Medsafe Beneficio não encontrado');

            return redirect(route('medsafeBeneficios.index'));
        }

        $medsafeBeneficio = $this->medsafeBeneficioRepository->update($request->all(), $id);

        Flash::success('Medsafe Beneficio atualizado com sucesso.');

        return redirect(route('medsafeBeneficios.index'));
    }

    /**
     * Remove the specified MedsafeBeneficio from storage.
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
                $this->medsafeBeneficioRepository->delete($id);
            }

            DB::commit();
            Flash::success('Medsafe Beneficio(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Medsafe Beneficio(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
