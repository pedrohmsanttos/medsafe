<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRenovacaoRequest;
use App\Http\Requests\UpdateRenovacaoRequest;
use App\Repositories\RenovacaoRepository;
use App\Repositories\ClienteRepository;
use App\Repositories\ParametroRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Parametro;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use Auth;

class RenovacaoController extends AppBaseController
{
    /** @var  RenovacaoRepository */
    private $renovacaoRepository;

    /** @var  ClienteRepository */
    private $clienteRepository;

    /** @var  ParametroRepository */
    private $parametroRepository;

    public function __construct(
        RenovacaoRepository $renovacaoRepo,
        ClienteRepository $clienteRepo,
        ParametroRepository $parametroRepo
        )
    {
        $this->renovacaoRepository = $renovacaoRepo;
        $this->clienteRepository = $clienteRepo;
        $this->parametroRepository = $parametroRepo;
        // Set Permissions
        $this->middleware('permission:renovacao_listar', ['only' => ['index']]); 
        $this->middleware('permission:renovacao_visualizar', ['only' => ['edit']]);
        $this->middleware('permission:renovacao_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Renovacao.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all(); 

        /** Titulo da página */
        $title = "Renovação";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Renovacao";
        /** Filtros */
        $request = $this->setOrderBy($request);
        $user = Auth::user();
        $parametro = Parametro::where('nome','apolices para renovação')->get();
        date_default_timezone_set('America/Recife');
        $dataHoje = date('Y-m-d', time());
        $data = date('Y-m-d', strtotime($dataHoje. ' + '.trim($parametro[0]->valor).' days'));

        if ($user->hasRole('corretor_user')) {
            $reqCliente = new Request();
            $reqCliente->attributes->add(['search'=>'corretor_id:'.$user->corretor()->first()->id]);
            $reqCliente->attributes->add(['searchFields'=>'corretor_id:=']);
            $this->renovacaoRepository->pushCriteria(new RequestCriteria($reqCliente));
        }
        $this->renovacaoRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->renovacaoRepository->filter($filtros);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $renovacaos = $this->renovacaoRepository->scopeQuery(function($query){
                    return $query->where('status','=',1)->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $renovacaos = $this->renovacaoRepository->scopeQuery(function($query){
                    return $query->where('status','=',1)->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $renovacaos = $this->renovacaoRepository->scopeQuery(function($query) use ($data,$dataHoje){
                    return $query->where('status','=',1)->where('data_vencimento','<=',$data)->where('data_vencimento','>=',$dataHoje);
                })->paginate();
            }
        }else{
            $renovacaos = $this->renovacaoRepository->scopeQuery(function($query) use ($data,$dataHoje){
                return $query->where('status','=',1)->where('data_vencimento','<=',$data)->where('data_vencimento','>=',$dataHoje);
            })->paginate();
        }
        return view('renovacaos.index', compact('title','breadcrumb','renovacaos', 'filters'));
    }

    /**
     * Show the form for creating a new Renovacao.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Renovação";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addRenovacao";

        return view('renovacaos.create', compact('title','breadcrumb'));
    }

    /**
     * Store a newly created Renovacao in storage.
     *
     * @param CreateRenovacaoRequest $request
     *
     * @return Response
     */
    public function store(CreateRenovacaoRequest $request)
    {
        $input = $request->all();

        $renovacao = $this->renovacaoRepository->create($input);

        Flash::success('Renovacao salvo com sucesso.');

        return redirect(route('renovacaos.index'));
    }

    /**
     * Display the specified Renovacao.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Renovação";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showRenovacao";
        
        $renovacao = $this->renovacaoRepository->findWithoutFail($id);

        if (empty($renovacao)) {
            Flash::error('Renovacao não encontrado');

            return redirect(route('renovacaos.index'));
        }

        return view('renovacaos.show', compact('title','breadcrumb','renovacao'));
    }

    /**
     * Show the form for editing the specified Renovacao.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $renovacao = $this->renovacaoRepository->findWithoutFail($id);
        $dataFormatada = strtotime($renovacao->data_vencimento);
        $renovacao->data_vencimento = date("d/m/Y", $dataFormatada);

        if (empty($renovacao)) {
            Flash::error('Renovacao não encontrado');

            return redirect(route('renovacaos.index'));
        }

        // Titulo da página
        $title = "Renovação";
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editRenovacao";
        $breadcrumb->id = $renovacao->id;
        $breadcrumb->titulo = $renovacao->id;

        return view('renovacaos.edit', compact('title','breadcrumb','renovacao'));
    }

    /**
     * Update the specified Renovacao in storage.
     *
     * @param  int              $id
     * @param UpdateRenovacaoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRenovacaoRequest $request)
    {
        $renovacao = $this->renovacaoRepository->findWithoutFail($id);

        if (empty($renovacao)) {
            Flash::error('Renovacao não encontrado');

            return redirect(route('renovacaos.index'));
        }

        $renovacao = $this->renovacaoRepository->update($request->all(), $id);

        Flash::success('Renovacao atualizado com sucesso.');

        return redirect(route('renovacaos.index'));
    }

    /**
     * Remove the specified Renovacao from storage.
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
                $this->renovacaoRepository->delete($id);
            }

            DB::commit();
            Flash::success('Renovacao(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Renovacao(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
