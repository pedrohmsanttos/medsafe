<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCorretoradmRequest;
use App\Http\Requests\UpdateCorretoradmRequest;
use App\Repositories\CorretoradmRepository;
use App\Repositories\CorretoraRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use App\Models\Apolice;
use App\Models\Corretoradm;
use App\Models\Comissao;
use App\Models\Pedido;
use App\Models\Ticket;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class CorretoradmController extends AppBaseController
{
    /** @var  CorretoradmRepository */
    private $corretoradmRepository;

    /** @var  CorretoradmRepository */
    private $corretoraRepository;

    public function __construct(
        CorretoradmRepository $corretoradmRepo,
        CorretoraRepository $corretoraRepo
        )
    {
        $this->corretoradmRepository = $corretoradmRepo;
        $this->corretoraRepository = $corretoraRepo;
        // Set Permissions
        $this->middleware('permission:corretoradm_listar', ['only' => ['index']]); 
        $this->middleware('permission:corretoradm_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:corretoradm_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:corretoradm_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:corretoradm_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Corretoradm.
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
        $breadcrumb->nome = "Corretoradm";
        /** Filtros */
        $this->corretoradmRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->corretoradmRepository->filter($filtros);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $corretoradms = $this->corretoradmRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $corretoradms = $this->corretoradmRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $corretoradms = $this->corretoradmRepository->paginate();
            }
        }else{
            $corretoradms = $this->corretoradmRepository->paginate();
        }

        return view('corretoradms.index', compact('title','breadcrumb','corretoradms', 'filters'));
    }

    /**
     * Show the form for creating a new Corretoradm.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Corretor";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addCorretoradm";

        return view('corretoradms.create', compact('title','breadcrumb'));
    }

    /**
     * Store a newly created Corretoradm in storage.
     *
     * @param CreateCorretoradmRequest $request
     *
     * @return Response
     */
    public function store(CreateCorretoradmRequest $request)
    {
        $input = $request->all();

        $corretoradm = $this->corretoradmRepository->create($input);

        Flash::success('Corretoradm salvo com sucesso.');

        return redirect(route('corretoradms.index'));
    }

    /**
     * Display the specified Corretoradm.
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
        $breadcrumb->nome = "showCorretoradm";
        
        $corretoradm = $this->corretoradmRepository->findWithoutFail($id);

        if (empty($corretoradm)) {
            Flash::error('Corretoradm não encontrado');

            return redirect(route('corretoradms.index'));
        }

        return view('corretoradms.show', compact('title','breadcrumb','corretoradm'));
    }

    /**
     * Show the form for editing the specified Corretoradm.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $corretoras = $this->corretoraRepository->orderBy('descricao')->all();
        $corretoradm = $this->corretoradmRepository->findWithoutFail($id);

        if (empty($corretoradm)) {
            Flash::error('Corretoradm não encontrado');

            return redirect(route('corretoradms.index'));
        }

        // Titulo da página
        $title = "Corretor";
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editCorretoradm";
        $breadcrumb->id = $corretoradm->id;
        $breadcrumb->titulo = $corretoradm->id;

        return view('corretoradms.edit', compact('title','breadcrumb','corretoras','corretoradm'));
    }

    /**
     * Update the specified Corretoradm in storage.
     *
     * @param  int              $id
     * @param UpdateCorretoradmRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCorretoradmRequest $request)
    {
        $corretoradm = $this->corretoradmRepository->findWithoutFail($id);
        

        if (empty($corretoradm)) {
            Flash::error('Corretoradm não encontrado');

            return redirect(route('corretoradms.index'));
        }
        $input = $request->all();
        $input['user_id'] = $corretoradm->user_id;
        $corretoradm = $this->corretoradmRepository->update($input, $id);

        Flash::success('Corretoradm atualizado com sucesso.');

        return redirect(route('corretoradms.index'));
    }

    /**
     * Remove the specified Corretoradm from storage.
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
                $corretor = Corretoradm::find($id);
                $apolices = Apolice::where('corretor_id',$id)->get();
                $comissoes = Comissao::where('corretor_id',$id)->get();
                $pedidos = Pedido::where('corretor_id',$id)->get();
                $tickets = Ticket::where('corretor_id',$id)->get();
                if( count($comissoes ) == 0 && count($apolices ) == 0 && count($tickets ) == 0 && count($pedidos ) == 0 ){
                    $this->corretoradmRepository->delete($id);
                } else{
                    $itensProibidos .= $corretor->nome.",";
                }

            }
            if( strlen($itensProibidos) > 0){
                $itensProibidos = substr($itensProibidos, 0, -1);
                DB::commit();
                Flash::error('Os Usuário(s): "'.$itensProibidos. '" não podem ser inativado(s) porque são utilizados em outras partes do sistema.');
                return response()->json([
                    'msg' => 'Sucesso'
                ]);
            }
            DB::commit();
            Flash::success('Corretor(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Corretoradm(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
