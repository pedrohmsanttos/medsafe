<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTipoAtividadeRequest;
use App\Http\Requests\UpdateTipoAtividadeRequest;
use App\Repositories\TipoAtividadeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Atividade;
use App\Models\TipoAtividade;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class TipoAtividadeController extends AppBaseController
{
    /** @var  TipoAtividadeRepository */
    private $tipoAtividadeRepository;

    public function __construct(TipoAtividadeRepository $tipoAtividadeRepo)
    {
        $this->tipoAtividadeRepository = $tipoAtividadeRepo;
        // Set Permissions
        $this->middleware('permission:tipo_atividade_listar', ['only' => ['index']]);
        $this->middleware('permission:tipo_atividade_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:tipo_atividade_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:tipo_atividade_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:tipo_atividade_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the TipoAtividade.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();

        /** Titulo da página */
        $title = "Tipo Atividade";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "TipoAtividade";
        /** Filtros */
        $this->tipoAtividadeRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->tipoAtividadeRepository->filter($filtros);

        if (isset($filtros['situacao'])) {
            if ($filtros['situacao'] == 'all') {
                $tipoAtividades = $this->tipoAtividadeRepository->scopeQuery(function ($query) {
                    return $query->withTrashed(); // com deletados
                })->paginate();
            } elseif ($filtros['situacao'] == 'inativo') {
                $tipoAtividades = $this->tipoAtividadeRepository->scopeQuery(function ($query) {
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            } else {
                $tipoAtividades = $this->tipoAtividadeRepository->paginate();
            }
        } else {
            $tipoAtividades = $this->tipoAtividadeRepository->paginate();
        }

        return view('tipo_atividades.index', compact('title', 'breadcrumb', 'tipoAtividades', 'filters'));
    }

    /**
     * Show the form for creating a new TipoAtividade.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Tipo Atividade";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addTipoAtividade";

        return view('tipo_atividades.create', compact('title', 'breadcrumb'));
    }

    /**
     * Store a newly created TipoAtividade in storage.
     *
     * @param CreateTipoAtividadeRequest $request
     *
     * @return Response
     */
    public function store(CreateTipoAtividadeRequest $request)
    {
        $input = $request->all();

        $tipoAtividade = $this->tipoAtividadeRepository->create($input);

        Flash::success('Tipo Atividade salvo com sucesso.');

        return redirect(route('tipoAtividades.index'));
    }

    /**
     * Display the specified TipoAtividade.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Tipo Atividade";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showTipoAtividade";
        
        $tipoAtividade = $this->tipoAtividadeRepository->findWithoutFail($id);

        if (empty($tipoAtividade)) {
            Flash::error('Tipo Atividade não encontrado');

            return redirect(route('tipoAtividades.index'));
        }

        return view('tipo_atividades.show', compact('title', 'breadcrumb', 'tipoAtividade'));
    }

    /**
     * Show the form for editing the specified TipoAtividade.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $tipoAtividade = $this->tipoAtividadeRepository->findWithoutFail($id);

        if (empty($tipoAtividade)) {
            Flash::error('Tipo Atividade não encontrado');

            return redirect(route('tipoAtividades.index'));
        }

        // Titulo da página
        $title = "Tipo Atividade";
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editTipoAtividade";
        $breadcrumb->id = $tipoAtividade->id;
        $breadcrumb->titulo = $tipoAtividade->id;

        return view('tipo_atividades.edit', compact('title', 'breadcrumb', 'tipoAtividade'));
    }

    /**
     * Update the specified TipoAtividade in storage.
     *
     * @param  int              $id
     * @param UpdateTipoAtividadeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTipoAtividadeRequest $request)
    {
        $tipoAtividade = $this->tipoAtividadeRepository->findWithoutFail($id);

        if (empty($tipoAtividade)) {
            Flash::error('Tipo Atividade não encontrado');

            return redirect(route('tipoAtividades.index'));
        }

        $tipoAtividade = $this->tipoAtividadeRepository->update($request->all(), $id);

        Flash::success('Tipo Atividade atualizado com sucesso.');

        return redirect(route('tipoAtividades.index'));
    }

    /**
     * Remove the specified TipoAtividade from storage.
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
        try {
            $itensProibidos = "";
            foreach ($ids as $id) {
                $tipo = TipoAtividade::find($id);
                $atividades = Atividade::where('tipo_atividade_id',$id)->get();
                
                if(count($atividades ) == 0){
                    $this->tipoAtividadeRepository->delete($id);
                } else{
                    $itensProibidos .= $tipo->descricao.",";
                }
            }

            if( strlen($itensProibidos) > 0){
                $itensProibidos = substr($itensProibidos, 0, -1);
                DB::commit();
                Flash::error('Os tipos de atividade(s): "'.$itensProibidos. '" não podem ser inativados porque são utilizados em outras partes do sistema.');
                return response()->json([
                    'msg' => 'Sucesso'
                ]);
            }

            DB::commit();
            Flash::success('Tipo Atividade(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Tipo Atividade(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
