<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlanoDeContasRequest;
use App\Http\Requests\UpdatePlanoDeContasRequest;
use App\Repositories\PlanoDeContasRepository;
use App\Repositories\ContaBancariaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Tesouraria;
use App\Models\PlanoDeContas;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class PlanoDeContasController extends AppBaseController
{
    /** @var  PlanoDeContasRepository */
    private $planoDeContasRepository;

    /** @var  ContaBancariaRepository */
    private $contaBancariaRepository;

    public function __construct(
        PlanoDeContasRepository $planoDeContasRepo,
        ContaBancariaRepository $contaBancariaRepo
    ) {
        $this->planoDeContasRepository = $planoDeContasRepo;
        $this->contaBancariaRepository = $contaBancariaRepo;
        // Set Permissions
        $this->middleware('permission:plano_contas_listar', ['only' => ['index']]);
        $this->middleware('permission:plano_contas_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:plano_contas_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:plano_contas_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:plano_contas_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the PlanoDeContas.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();

        /** Titulo da página */
        $title = "Plano de Contas";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "planodecontas";

        $this->planoDeContasRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->planoDeContasRepository->filter($filtros);

        if (isset($filtros['situacao'])) {
            if ($filtros['situacao'] == 'all') {
                $planoDeContas = $this->planoDeContasRepository->scopeQuery(function ($query) {
                    return $query->withTrashed(); // com deletados
                })->paginate();
            } elseif ($filtros['situacao'] == 'inativo') {
                $planoDeContas = $this->planoDeContasRepository->scopeQuery(function ($query) {
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            } else {
                $planoDeContas = $this->planoDeContasRepository->paginate();
            }
        } else {
            $planoDeContas = $this->planoDeContasRepository->paginate();
        }

        return view('plano_de_contas.index', compact('title', 'breadcrumb', 'planoDeContas', 'filters'));
    }

    /**
     * Show the form for creating a new PlanoDeContas.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Adicionar Plano de Contas";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addPlanodecontas";

        $contasBancarias = $this->contaBancariaRepository->all();

        return view('plano_de_contas.create', compact('title', 'breadcrumb', 'contasBancarias'));
    }

    /**
     * Store a newly created PlanoDeContas in storage.
     *
     * @param CreatePlanoDeContasRequest $request
     *
     * @return Response
     */
    public function store(CreatePlanoDeContasRequest $request)
    {
        $input = $request->all();

        $planoDeContas = $this->planoDeContasRepository->create($input);

        Flash::success('Plano De Contas cadastrado com sucesso.');

        return redirect(route('planodecontas.index'));
    }

    /**
     * Display the specified PlanoDeContas.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $planoDeContas = $this->planoDeContasRepository->findWithoutFail($id);

        if (empty($planoDeContas)) {
            Flash::error('Plano De Contas não encontrado');

            return redirect(route('planoDeContas.index'));
        }
        
        return view('plano_de_contas.show')->with('planoDeContas', $planoDeContas);
    }

    /**
     * Show the form for editing the specified PlanoDeContas.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $planoDeContas   = $this->planoDeContasRepository->findWithoutFail($id);
        $contasBancarias = $this->contaBancariaRepository->all();
        if (empty($planoDeContas)) {
            Flash::error('Plano de conta não encontrado!');

            return redirect(route('plano_de_contas.index'));
        }

        // Titulo da página
        $title = "Editar";
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editPlanodecontas";
        $breadcrumb->id = $planoDeContas->id;
        $breadcrumb->titulo = $planoDeContas->descricao;
        
        return view('plano_de_contas.edit', compact('title', 'breadcrumb', 'planoDeContas', 'contasBancarias'));
    }

    /**
     * Update the specified PlanoDeContas in storage.
     *
     * @param  int              $id
     * @param UpdatePlanoDeContasRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePlanoDeContasRequest $request)
    {
        $planoDeContas = $this->planoDeContasRepository->findWithoutFail($id);

        if (empty($planoDeContas)) {
            Flash::error('Plano De Contas não encontrado!');

            return redirect(route('planodecontas.index'));
        }

        $array = $request->all();
        $array["caixa"] = $request->caixa;
        $array["cliente"] = $request->cliente;
        $array["banco"] = $request->banco;
        $array["fornecedor"] = $request->fornecedor;
        
        $planoDeContas = $this->planoDeContasRepository->update($array, $id);
        
        Flash::success('Plano De Contas atualizado com sucesso!');

        return redirect(route('planodecontas.index'));
    }

    /**
     * Remove the specified PlanoDeContas from storage.
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
                $tesourarias = Tesouraria::where('plano_de_contas_id',$id)->get();
                $planoDeConta = PlanoDeContas::find($id);
                if(count( $tesourarias ) == 0){
                    $this->planoDeContasRepository->delete($id);
                } else{
                    $itensProibidos .= $planoDeConta->descricao.",";
                }
            }
            if( strlen($itensProibidos) > 0){
                $itensProibidos = substr($itensProibidos, 0, -1);
                DB::commit();
                Flash::error('Os Planos de Conta(s): "'.$itensProibidos. '" não podem ser inativados porque são utilizados em outras partes do sistema.');
                return response()->json([
                    'msg' => 'Sucesso'
                ]);
            }
            DB::commit();
            Flash::success('Plano(s) De Contas inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Plano(s) De Contas!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
