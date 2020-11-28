<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBeneficioRequest;
use App\Http\Requests\UpdateBeneficioRequest;
use App\Repositories\BeneficioRepository;
use App\Repositories\ApoliceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use Illuminate\Support\Facades\Auth;

class BeneficioController extends AppBaseController
{
    /** @var  BeneficioRepository */
    private $beneficioRepository;

    /** @var  ApoliceRepository */
    private $apoliceRepository;

    public function __construct(
        BeneficioRepository $beneficioRepo,
        ApoliceRepository $apoliceRepo
    ) {
        $this->beneficioRepository = $beneficioRepo;
        $this->apoliceRepository = $apoliceRepo;
        // // Set Permissions
        // $this->middleware('permission:beneficio_listar', ['only' => ['index']]);
        // $this->middleware('permission:beneficio_adicionar', ['only' => ['create', 'store']]);
        // $this->middleware('permission:beneficio_editar', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:beneficio_deletar', ['only' => ['destroy']]);
        // $this->middleware('permission:beneficio_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Beneficio.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();

        /** Titulo da página */
        $title = "Benefício";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Benefício";

        $apolices = $this->apoliceRepository->findWhere([
            'cliente_id' => Auth::user()->cliente()->first()->id
        ])->all();

        return view('beneficios.index', compact('title', 'breadcrumb', 'apolices'));
    }

    /**
     * Show the form for creating a new Beneficio.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Beneficio";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addBeneficio";

        return view('beneficios.create', compact('title', 'breadcrumb'));
    }

    /**
     * Store a newly created Beneficio in storage.
     *
     * @param CreateBeneficioRequest $request
     *
     * @return Response
     */
    public function store(CreateBeneficioRequest $request)
    {
        $input = $request->all();

        $beneficio = $this->beneficioRepository->create($input);

        Flash::success('Beneficio salvo com sucesso.');

        return redirect(route('beneficios.index'));
    }

    /**
     * Display the specified Beneficio.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Beneficio";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showBeneficio";
        
        $beneficio = $this->beneficioRepository->findWithoutFail($id);

        if (empty($beneficio)) {
            Flash::error('Beneficio não encontrado');

            return redirect(route('beneficios.index'));
        }

        return view('beneficios.show', compact('title', 'breadcrumb', 'beneficio'));
    }

    /**
     * Show the form for editing the specified Beneficio.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $beneficio = $this->beneficioRepository->findWithoutFail($id);

        if (empty($beneficio)) {
            Flash::error('Beneficio não encontrado');

            return redirect(route('beneficios.index'));
        }

        // Titulo da página
        $title = "Beneficio";
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editBeneficio";
        $breadcrumb->id = $beneficio->id;
        $breadcrumb->titulo = $beneficio->id;

        return view('beneficios.edit', compact('title', 'breadcrumb', 'beneficio'));
    }

    /**
     * Update the specified Beneficio in storage.
     *
     * @param  int              $id
     * @param UpdateBeneficioRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBeneficioRequest $request)
    {
        $beneficio = $this->beneficioRepository->findWithoutFail($id);

        if (empty($beneficio)) {
            Flash::error('Beneficio não encontrado');

            return redirect(route('beneficios.index'));
        }

        $beneficio = $this->beneficioRepository->update($request->all(), $id);

        Flash::success('Beneficio atualizado com sucesso.');

        return redirect(route('beneficios.index'));
    }

    /**
     * Remove the specified Beneficio from storage.
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
                $this->beneficioRepository->delete($id);
            }

            DB::commit();
            Flash::success('Beneficio(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Beneficio(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
