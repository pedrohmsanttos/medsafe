<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateApoliceRequest;
use App\Http\Requests\UpdateApoliceRequest;
use App\Repositories\ApoliceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use Auth;

class ApoliceController extends AppBaseController
{
    /** @var  ApoliceRepository */
    private $apoliceRepository;

    public function __construct(ApoliceRepository $apoliceRepo)
    {
        $this->apoliceRepository = $apoliceRepo;
        // Set Permissions
        // $this->middleware('permission:apolice_listar', ['only' => ['index']]);
        // $this->middleware('permission:apolice_adicionar', ['only' => ['create', 'store']]);
        // $this->middleware('permission:apolice_editar', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:apolice_deletar', ['only' => ['destroy']]);
        // $this->middleware('permission:apolice_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Apolice.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();

        /** Titulo da página */
        $title = "Apólice";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Apolice";
        /** Filtros */
        $user = Auth::user();
        if ($user->hasRole('cliente_user')) {
            $reqCliente = new Request();
            $reqCliente->attributes->add(['search'=>'cliente_id:'.$user->cliente()->first()->id]);
            $reqCliente->attributes->add(['searchFields'=>'cliente_id:=']);
            $this->apoliceRepository->pushCriteria(new RequestCriteria($reqCliente));
        }
        if ($user->hasRole('corretor_user')) {
            $reqCliente = new Request();
            $reqCliente->attributes->add(['search'=>'corretor_id:'.$user->corretor()->first()->id]);
            $reqCliente->attributes->add(['searchFields'=>'corretor_id:=']);
            $this->apoliceRepository->pushCriteria(new RequestCriteria($reqCliente));
        }
        
        $this->apoliceRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->apoliceRepository->filter($filtros);

        if (isset($filtros['situacao'])) {
            if ($filtros['situacao'] == 'all') {
                $apolices = $this->apoliceRepository->scopeQuery(function ($query) {
                    return $query->withTrashed(); // com deletados
                })->paginate();
            } elseif ($filtros['situacao'] == 'inativo') {
                $apolices = $this->apoliceRepository->scopeQuery(function ($query) {
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            } else {
                $apolices = $this->apoliceRepository->paginate();
            }
        } else {
            $apolices = $this->apoliceRepository->paginate();
        }

        return view('apolices.index', compact('title', 'breadcrumb', 'apolices', 'filters'));
    }

    /**
     * Show the form for creating a new Apolice.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Apólice";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addApolice";

        return view('apolices.create', compact('title', 'breadcrumb'));
    }

    /**
     * Store a newly created Apolice in storage.
     *
     * @param CreateApoliceRequest $request
     *
     * @return Response
     */
    public function store(CreateApoliceRequest $request)
    {
        $input = $request->all();

        $apolice = $this->apoliceRepository->create($input);

        Flash::success('Apolice salvo com sucesso.');

        return redirect(route('apolices.index'));
    }

    /**
     * Display the specified Apolice.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Apólice";
        
        $apolice = $this->apoliceRepository->findWithoutFail($id);

        if (empty($apolice)) {
            Flash::error('Apólice não encontrado');

            return redirect(route('apolices.index'));
        }

        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showApolice";
        $breadcrumb->id = $apolice->id;
        $breadcrumb->titulo = $apolice->id;

        return view('apolices.show', compact('title', 'breadcrumb', 'apolice'));
    }

    /**
     * Show the form for editing the specified Apolice.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $apolice = $this->apoliceRepository->findWithoutFail($id);

        if (empty($apolice)) {
            Flash::error('Apólice não encontrado');

            return redirect(route('apolices.index'));
        }

        // Titulo da página
        $title = "Apólice";
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editApolice";
        $breadcrumb->id = $apolice->id;
        $breadcrumb->titulo = $apolice->id;

        return view('apolices.edit', compact('title', 'breadcrumb', 'apolice'));
    }

    /**
     * Update the specified Apolice in storage.
     *
     * @param  int              $id
     * @param UpdateApoliceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateApoliceRequest $request)
    {
        $apolice = $this->apoliceRepository->findWithoutFail($id);

        if (empty($apolice)) {
            Flash::error('Apólice não encontrado');

            return redirect(route('apolices.index'));
        }

        $apolice = $this->apoliceRepository->update($request->all(), $id);

        Flash::success('Apólice atualizado com sucesso.');

        return redirect(route('apolices.index'));
    }

    /**
     * Remove the specified Apolice from storage.
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
            foreach ($ids as $id) {
                $this->apoliceRepository->delete($id);
            }

            DB::commit();
            Flash::success('Apólice(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Apólice(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
