<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOcorrenciaRequest;
use App\Http\Requests\UpdateOcorrenciaRequest;
use App\Repositories\OcorrenciaRepository;
use App\Repositories\CategoriaTicketRepository;
use App\Repositories\ClienteRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use App\Models\Corretor;

class OcorrenciaController extends AppBaseController
{
    /** @var  OcorrenciaRepository */
    private $ocorrenciaRepository;

    /** @var  CategoriaTicketRepository */
    private $categoriaTicketRepository;

    /** @var  ClienteRepository */
    private $clienteRepository;

    public function __construct(
        OcorrenciaRepository $ocorrenciaRepo,
        CategoriaTicketRepository $categoriaTicketRepo,
        ClienteRepository $clienteRepo
        )
    {
        $this->ocorrenciaRepository = $ocorrenciaRepo;
        $this->categoriaTicketRepository = $categoriaTicketRepo;
        $this->clienteRepository = $clienteRepo;
        // Set Permissions
        // $this->middleware('permission:ocorrencia_listar', ['only' => ['index']]); 
        // $this->middleware('permission:ocorrencia_adicionar', ['only' => ['create', 'store']]);
        // $this->middleware('permission:ocorrencia_editar', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:ocorrencia_deletar', ['only' => ['destroy']]);
        // $this->middleware('permission:ocorrencia_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Ocorrencia.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all(); 
        $clientes = $this->clienteRepository->all();
        $request = $this->setOrderBy($request);

        /** Titulo da página */
        $title = "Ocorrência";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Ocorrencia";
        /** Filtros */
        $id = Auth::user()->id;
        $corretor = Corretor::find($id)->get();
        $corretorId = $corretor[0]->id;
        $reqCorretor = new Request();
        $reqCorretor->attributes->add(['search'=>'corretor_id:'.$corretorId]);
        $reqCorretor->attributes->add(['searchFields'=>'corretor_id:=']);
        $this->ocorrenciaRepository->pushCriteria(new RequestCriteria($reqCorretor));
        $this->ocorrenciaRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->ocorrenciaRepository->filter($filtros);
        $id = Auth::user()->id;
        $corretor = Corretor::find($id)->get();
        

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $ocorrencias = $this->ocorrenciaRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $ocorrencias = $this->ocorrenciaRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $ocorrencias = $this->ocorrenciaRepository->paginate();
            }
        }else{
            $ocorrencias = $this->ocorrenciaRepository->paginate();
        }


        return view('ocorrencias.index', compact('title','breadcrumb','ocorrencias','corretor','filters'));
    }

    /**
     * Show the form for creating a new Ocorrencia.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Ocorrência";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addOcorrencia";
        $categorias = $this->categoriaTicketRepository->all();
        $clientes = $this->clienteRepository->orderBy('nomeFantasia')->all()->where('user_id','<>','');

        return view('ocorrencias.create', compact('title','breadcrumb','categorias','clientes'));
    }

    /**
     * Store a newly created Ocorrencia in storage.
     *
     * @param CreateOcorrenciaRequest $request
     *
     * @return Response
     */
    public function store(CreateOcorrenciaRequest $request)
    {
        $input = $request->all();
        $id = Auth::user()->id;
        $corretor = Corretor::find($id)->get();
        $corretorId = $corretor[0]->id;
        $input['corretor_id'] = $corretorId;
        $input['prioridade'] = 0;
        $input['status']     = 0;

        $ocorrencia = $this->ocorrenciaRepository->create($input);

        Flash::success('Ocorrencia salvo com sucesso.');

        return redirect(route('ocorrencias.index'));
    }

    /**
     * Display the specified Ocorrencia.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {

        $ocorrencia = $this->ocorrenciaRepository->findWithoutFail($id);

        if (empty($ocorrencia)) {
            Flash::error('Ticket não encontrado');

            return redirect(route('ocorrencias.index'));
        }
        /** Titulo da página */
        $title = "Ocorrência";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showOcorrencia";
        $breadcrumb->id = $ocorrencia->id;
        $breadcrumb->titulo = $ocorrencia->titulo;
        
        $ocorrencia = $this->ocorrenciaRepository->findWithoutFail($id);

        if (empty($ocorrencia)) {
            Flash::error('Ocorrencia não encontrado');

            return redirect(route('ocorrencias.index'));
        }

        return view('ocorrencias.show', compact('title','breadcrumb','ocorrencia'));
    }

    /**
     * Show the form for editing the specified Ocorrencia.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $ocorrencia = $this->ocorrenciaRepository->findWithoutFail($id);

        if (empty($ocorrencia)) {
            Flash::error('Ocorrencia não encontrado');

            return redirect(route('ocorrencias.index'));
        }

        // Titulo da página
        $title = "Ocorrência";
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editOcorrencia";
        $breadcrumb->id = $ocorrencia->id;
        $breadcrumb->titulo = $ocorrencia->id;

        return view('ocorrencias.edit', compact('title','breadcrumb','ocorrencia'));
    }

    /**
     * Update the specified Ocorrencia in storage.
     *
     * @param  int              $id
     * @param UpdateOcorrenciaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOcorrenciaRequest $request)
    {
        $ocorrencia = $this->ocorrenciaRepository->findWithoutFail($id);

        if (empty($ocorrencia)) {
            Flash::error('Ocorrencia não encontrado');

            return redirect(route('ocorrencias.index'));
        }

        $ocorrencia = $this->ocorrenciaRepository->update($request->all(), $id);

        Flash::success('Ocorrencia atualizado com sucesso.');

        return redirect(route('ocorrencias.index'));
    }

    /**
     * Remove the specified Ocorrencia from storage.
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
                $this->ocorrenciaRepository->delete($id);
            }

            DB::commit();
            Flash::success('Ocorrencia(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Ocorrencia(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
