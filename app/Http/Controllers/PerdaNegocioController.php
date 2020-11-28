<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePerdaNegocioRequest;
use App\Http\Requests\UpdatePerdaNegocioRequest;
use App\Repositories\PerdaNegocioRepository;
use App\Repositories\NegocioRepository;
use App\Repositories\MotivoPerdaNegocioRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Negocio;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use DateTime;
use Auth;

class PerdaNegocioController extends AppBaseController
{
    /** @var  PerdaNegocioRepository */
    private $perdaNegocioRepository;
    /** @var  NegocioRepository */
    private $negocioRepository;
    /** @var  MotivoPerdaNegocioRepository */
    private $motivoPerdaNegocioRepository;

    public function __construct(
        PerdaNegocioRepository $perdaNegocioRepo,
        NegocioRepository $negocioRepo,
        MotivoPerdaNegocioRepository $formaDePagamentoRepo
    ) {
        $this->perdaNegocioRepository       = $perdaNegocioRepo;
        $this->negocioRepository            = $negocioRepo;
        $this->motivoPerdaNegocioRepository = $formaDePagamentoRepo;
    }

    /**
     * Display a listing of the PerdaNegocio.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();

        /** Titulo da página */
        $title = "Perda de Negócio";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "PerdaNegocio";
        /** Filtros */
        $this->perdaNegocioRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->perdaNegocioRepository->filter($filtros);

        if (isset($filtros['situacao'])) {
            if ($filtros['situacao'] == 'all') {
                $perdaNegocios = $this->perdaNegocioRepository->scopeQuery(function ($query) {
                    return $query->withTrashed(); // com deletados
                })->paginate();
            } elseif ($filtros['situacao'] == 'inativo') {
                $perdaNegocios = $this->perdaNegocioRepository->scopeQuery(function ($query) {
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            } else {
                $perdaNegocios = $this->perdaNegocioRepository->paginate();
            }
        } else {
            $perdaNegocios = $this->perdaNegocioRepository->paginate();
        }

        return view('perda_negocios.index', compact('title', 'breadcrumb', 'perdaNegocios', 'filters'));
    }

    /**
     * Show the form for creating a new PerdaNegocio.
     *
     * @return Response
     */
    public function create($idNegocio = null)
    {
        /** Titulo da página */
        $title = "Perda de Negócio";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addPerdaNegocio";
        /** Attrs */
        $negocios       = $this->negocioRepository->findWhere([
            'status' => 0,
            'id'     => $idNegocio
        ]);
        $motivos        = $this->motivoPerdaNegocioRepository->all();
        $usuarios       = User::all();
        $currentUser    = Auth::user();
        $currentnegocio = new \stdClass;
        if (!empty($idNegocio)) {
            $currentnegocio = $this->negocioRepository->findWithoutFail($idNegocio);
        } else {
            $currentnegocio->id = 0;
        }

        return view('perda_negocios.create', compact('title', 'breadcrumb', 'negocios', 'usuarios', 'currentUser', 'currentnegocio', 'motivos'));
    }

    /**
     * Store a newly created PerdaNegocio in storage.
     *
     * @param CreatePerdaNegocioRequest $request
     *
     * @return Response
     */
    public function store(CreatePerdaNegocioRequest $request)
    {
        $input        = $request->all();
        $negocio      = $this->negocioRepository->findWithoutFail($input['negocio_id']);

        if (empty($negocio)) {
            Flash::error('Negócio não encontrado ou inativado!');

            return redirect(route('negocios.index'));
        }

        DB::beginTransaction();
        try {
            if (!empty($input['data_perda']) && count(explode('/', $input['data_perda'])) > 1) {
                $date                  = DateTime::createFromFormat('d/m/Y', $input['data_perda']);
                $usableDate            = $date->format('Y-m-d');
                $input['data_perda'] = $usableDate;
            }

            $perdaNegocio        = $this->perdaNegocioRepository->create($input);
            $negocio->data_perda = $input['data_perda'];
            $negocio->status     = '1';
            $negocio->motivo_perda_negocio_id = $input['motivo_perda_id'];
            $negocio->save();

            DB::commit();
            Flash::success('Perda de negócio salvo com sucesso.');
        } catch (\Exception $e) {
            DB::rollBack();

            Flash::error('Erro ao tentar cadastrar perda de negócio!');
        }

        return redirect(route('negocios.index'));
    }

    /**
     * Display the specified PerdaNegocio.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Perda de Negócio";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showPerdaNegocio";
        
        $perdaNegocio = $this->perdaNegocioRepository->findWithoutFail($id);

        if (empty($perdaNegocio)) {
            Flash::error('Perda de Negócio não encontrado');

            return redirect(route('perdaNegocios.index'));
        }

        return view('perda_negocios.show', compact('title', 'breadcrumb', 'perdaNegocio'));
    }

    /**
     * Show the form for editing the specified PerdaNegocio.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $perdaNegocio = $this->perdaNegocioRepository->findWithoutFail($id);

        if (empty($perdaNegocio)) {
            Flash::error('Perda de Negócio não encontrado');

            return redirect(route('perdaNegocios.index'));
        }

        // Titulo da página
        $title = "Perda de Negócio";
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editPerdaNegocio";
        $breadcrumb->id = $perdaNegocio->id;
        $breadcrumb->titulo = $perdaNegocio->id;

        return view('perda_negocios.edit', compact('title', 'breadcrumb', 'perdaNegocio'));
    }

    /**
     * Update the specified PerdaNegocio in storage.
     *
     * @param  int              $id
     * @param UpdatePerdaNegocioRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePerdaNegocioRequest $request)
    {
        $perdaNegocio = $this->perdaNegocioRepository->findWithoutFail($id);

        if (empty($perdaNegocio)) {
            Flash::error('Perda de Negócio não encontrado');

            return redirect(route('perdaNegocios.index'));
        }

        $perdaNegocio = $this->perdaNegocioRepository->update($request->all(), $id);

        Flash::success('Perda de Negócio atualizado com sucesso.');

        return redirect(route('perdaNegocios.index'));
    }

    /**
     * Remove the specified PerdaNegocio from storage.
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
                $this->perdaNegocioRepository->delete($id);
            }

            DB::commit();
            Flash::success('Perda de Negócio(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Perda de Negócio(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
