<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNovidadeRequest;
use App\Http\Requests\UpdateNovidadeRequest;
use App\Repositories\NovidadeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use Auth;

class NovidadeController extends AppBaseController
{
    /** @var  NovidadeRepository */
    private $novidadeRepository;

    public function __construct(NovidadeRepository $novidadeRepo)
    {
        $this->novidadeRepository = $novidadeRepo;
        // Set Permissions
        //$this->middleware('permission:novidades_listar', ['only' => ['index']]);
        $this->middleware('permission:novidades_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:novidades_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:novidades_deletar', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the Novidade.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();
        $this->novidadeRepository->pushCriteria(new RequestCriteria($request));
        
        /** Titulo da página */
        $title = "Novidades";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "novidades";

        $filters = $this->novidadeRepository->filter($filtros);

        if (isset($filtros['situacao'])) {
            if ($filtros['situacao'] == 'all') {
                $novidades = $this->novidadeRepository->scopeQuery(function ($query) {
                    return $query->withTrashed(); // com deletados
                })->paginate();
            } elseif ($filtros['situacao'] == 'inativo') {
                $novidades = $this->novidadeRepository->scopeQuery(function ($query) {
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            } else {
                $novidades = $this->novidadeRepository->paginate();
            }
        } else {
            $novidades = $this->novidadeRepository->paginate();
        }

        return view('novidades.index', compact('title', 'breadcrumb', 'novidades', 'filters'));
    }

    /**
     * Show the form for creating a new Novidade.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Adicionar Novidades";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addNovidade";
        return view('novidades.create', compact('title', 'breadcrumb'));
    }

    /**
     * Store a newly created Novidade in storage.
     *
     * @param CreateNovidadeRequest $request
     *
     * @return Response
     */
    public function store(CreateNovidadeRequest $request)
    {
        $input = $request->all();

        $novidade = $this->novidadeRepository->create($input);

        Flash::success('Novidade cadastrada com sucesso.');

        return redirect(route('novidades.index'));
    }

    /**
     * Display the specified Novidade.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $novidade = $this->novidadeRepository->findWithoutFail($id);

        if (empty($novidade)) {
            Flash::error('Novidade not found');

            return redirect(route('novidades.index'));
        }
        /** Titulo da página */
        $title = "Novidade";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showNovidade";
        $breadcrumb->id = $novidade->id;
        $breadcrumb->titulo = $novidade->titulo;

        return view('novidades.show', compact('title', 'breadcrumb', 'novidade'));
    }

    /**
     * Show the form for editing the specified Novidade.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $novidade  = $this->novidadeRepository->findWithoutFail($id);
        
        if (empty($novidade)) {
            Flash::error('Novidade não encontrada!');

            return redirect(route('novidades.index'));
        }

        // Titulo da página
        $title = "Editar: ". $novidade->titulo;
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editNovidade";
        $breadcrumb->id = $novidade->id;
        $breadcrumb->titulo = $novidade->titulo;

        return view('novidades.edit', compact('title', 'breadcrumb', 'novidade'));
    }

    /**
     * Update the specified Novidade in storage.
     *
     * @param  int              $id
     * @param UpdateNovidadeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNovidadeRequest $request)
    {
        $novidade = $this->novidadeRepository->findWithoutFail($id);

        if (empty($novidade)) {
            Flash::error('Novidade não encontrada!');

            return redirect(route('novidades.index'));
        }

        $novidade = $this->novidadeRepository->update($request->all(), $id);

        Flash::success('Novidade atualizada com sucesso.');

        return redirect(route('novidades.index'));
    }

    /**
     * Remove the specified Novidade from storage.
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
                $this->novidadeRepository->delete($id);
            }

            DB::commit();
            Flash::success('Novidade(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Novidade!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
