<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSeguradoRequest;
use App\Http\Requests\UpdateSeguradoRequest;
use App\Repositories\SeguradoRepository;
use App\Repositories\ClienteRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Cliente;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use Auth;

class SeguradoController extends AppBaseController
{
    /** @var  SeguradoRepository */
    private $seguradoRepository;

    /** @var  ClienteRepository */
    private $clienteRepository;

    public function __construct(
    SeguradoRepository $seguradoRepo,
    ClienteRepository $clienteRepo
    ) {
        $this->seguradoRepository = $seguradoRepo;
        $this->clienteRepository = $clienteRepo;
        // Set Permissions
        $this->middleware('permission:segurado_listar', ['only' => ['index']]);
        $this->middleware('permission:segurado_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Segurado.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all(); 

        /** Titulo da página */
        $title = "Segurado";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Segurado";
        /** Filtros */
        $request = $this->setOrderBy($request);
        $user = Auth::user();
        if ($user->hasRole('corretor_user')) {
            $reqCliente = new Request();
            $reqCliente->attributes->add(['search'=>'corretor_id:'.$user->corretor()->first()->id]);
            $reqCliente->attributes->add(['searchFields'=>'corretor_id:=']);
            $clientes = $this->clienteRepository->orderBy('nomeFantasia')->all();
            $this->seguradoRepository->pushCriteria(new RequestCriteria($reqCliente));
        }
        $this->seguradoRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->seguradoRepository->filter($filtros);
        $nomeCliente = "";
        if(isset($filters[0]->campo) && $filters[0]->campo == 'cliente_id'){
            $nomeCliente = Cliente::find($filters[0]->valor)->nomeFantasia;
            
        }

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $segurados = $this->seguradoRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $segurados = $this->seguradoRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $segurados = $this->seguradoRepository->paginate();
            }
        }else{
            $segurados = $this->seguradoRepository->paginate();
        }

        return view('segurados.index', compact('title','nomeCliente','clientes','breadcrumb','segurados', 'filters'));
    }

    /**
     * Show the form for creating a new Segurado.
     *
     * @return Response
     */

    /**
     * Store a newly created Segurado in storage.
     *
     * @param CreateSeguradoRequest $request
     *
     * @return Response
     */
    public function store(CreateSeguradoRequest $request)
    {
        $input = $request->all();

        $segurado = $this->seguradoRepository->create($input);

        Flash::success('Segurado salvo com sucesso.');

        return redirect(route('segurados.index'));
    }

    /**
     * Display the specified Segurado.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Segurado";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showSegurado";
        
        $segurado = $this->seguradoRepository->findWithoutFail($id);

        if (empty($segurado)) {
            Flash::error('Segurado não encontrado');

            return redirect(route('segurados.index'));
        }

        return view('segurados.show', compact('title','breadcrumb','segurado'));
    }

    /**
     * Show the form for editing the specified Segurado.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $segurado = $this->seguradoRepository->findWithoutFail($id);

        if (empty($segurado)) {
            Flash::error('Segurado não encontrado');

            return redirect(route('segurados.index'));
        }

        // Titulo da página
        $title = "Segurado";
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editSegurado";
        $breadcrumb->id = $segurado->id;
        $breadcrumb->titulo = $segurado->id;

        return view('segurados.edit', compact('title','breadcrumb','segurado'));
    }

    /**
     * Update the specified Segurado in storage.
     *
     * @param  int              $id
     * @param UpdateSeguradoRequest $request
     *
     * @return Response
     */


    /**
     * Remove the specified Segurado from storage.
     *
     * @param  int $id
     *
     * @return Response
     */

}
