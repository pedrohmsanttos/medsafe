<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContaTransactionRequest;
use App\Http\Requests\UpdateContaTransactionRequest;
use App\Repositories\ContaTransactionRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

class ContaTransactionController extends AppBaseController
{
    /** @var  ContaTransactionRepository */
    private $contaTransactionRepository;

    public function __construct(ContaTransactionRepository $contaTransactionRepo)
    {
        $this->contaTransactionRepository = $contaTransactionRepo;
        // Set Permissions
        $this->middleware('permission:contaTransaction_listar', ['only' => ['index']]); 
        $this->middleware('permission:contaTransaction_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:contaTransaction_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:contaTransaction_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:contaTransaction_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the ContaTransaction.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all(); 

        /** Titulo da página */
        $title = "Conta Transaction";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Conta Transaction";
        /** Filtros */
        $this->contaTransactionRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->contaTransactionRepository->filter($filtros);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $contaTransactions = $this->contaTransactionRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $contaTransactions = $this->contaTransactionRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $contaTransactions = $this->contaTransactionRepository->paginate();
            }
        }else{
            $contaTransactions = $this->contaTransactionRepository->paginate();
        }

        return view('conta_transactions.index', compact('title','breadcrumb','contaTransactions', 'filters'));
    }

    /**
     * Show the form for creating a new ContaTransaction.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Conta Transaction";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addConta Transaction";

        return view('conta_transactions.create', compact('title','breadcrumb'));
    }

    /**
     * Store a newly created ContaTransaction in storage.
     *
     * @param CreateContaTransactionRequest $request
     *
     * @return Response
     */
    public function store(CreateContaTransactionRequest $request)
    {
        $input = $request->all();

        $contaTransaction = $this->contaTransactionRepository->create($input);

        Flash::success('Conta Transaction salvo com sucesso.');

        return redirect(route('contaTransactions.index'));
    }

    /**
     * Display the specified ContaTransaction.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Conta Transaction";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showConta Transaction";
        
        $contaTransaction = $this->contaTransactionRepository->findWithoutFail($id);

        if (empty($contaTransaction)) {
            Flash::error('Conta Transaction não encontrado');

            return redirect(route('contaTransactions.index'));
        }

        return view('conta_transactions.show', compact('title','breadcrumb','contaTransaction'));
    }

    /**
     * Show the form for editing the specified ContaTransaction.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $contaTransaction = $this->contaTransactionRepository->findWithoutFail($id);

        if (empty($contaTransaction)) {
            Flash::error('Conta Transaction não encontrado');

            return redirect(route('contaTransactions.index'));
        }

        // Titulo da página
        $title = "Conta Transaction";
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editConta Transaction";
        $breadcrumb->id = $contaTransaction->id;
        $breadcrumb->titulo = $contaTransaction->id;

        return view('conta_transactions.edit', compact('title','breadcrumb','contaTransaction'));
    }

    /**
     * Update the specified ContaTransaction in storage.
     *
     * @param  int              $id
     * @param UpdateContaTransactionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateContaTransactionRequest $request)
    {
        $contaTransaction = $this->contaTransactionRepository->findWithoutFail($id);

        if (empty($contaTransaction)) {
            Flash::error('Conta Transaction não encontrado');

            return redirect(route('contaTransactions.index'));
        }

        $contaTransaction = $this->contaTransactionRepository->update($request->all(), $id);

        Flash::success('Conta Transaction atualizado com sucesso.');

        return redirect(route('contaTransactions.index'));
    }

    /**
     * Remove the specified ContaTransaction from storage.
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
                $this->contaTransactionRepository->delete($id);
            }

            DB::commit();
            Flash::success('Conta Transaction(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Conta Transaction(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
