<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContaBancariaRequest;
use App\Http\Requests\UpdateContaBancariaRequest;
use App\Repositories\ContaBancariaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\ContaBancaria;
use App\Models\PlanoDeContas;
use App\Models\Tesouraria;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use DateTime;

class ContaBancariaController extends AppBaseController
{
    /** @var  ContaBancariaRepository */
    private $contaBancariaRepository;

    public function __construct(ContaBancariaRepository $contaBancariaRepo)
    {
        $this->contaBancariaRepository = $contaBancariaRepo;
        // Set Permissions
        $this->middleware('permission:conta_bancaria_listar', ['only' => ['index']]); 
        $this->middleware('permission:conta_bancaria_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:conta_bancaria_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:conta_bancaria_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:conta_bancaria_visualizar', ['only' => ['show']]);  
    }

    /**
     * Display a listing of the ContaBancaria.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all(); 

        /** Titulo da página */
        $title = "Contas bancárias";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "contaBancarias";

        $this->contaBancariaRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->contaBancariaRepository->filter($filtros);

        if(isset($filtros['situacao'])){
            if($filtros['situacao'] == 'all'){
                $contas = $this->contaBancariaRepository->scopeQuery(function($query){
                    return $query->withTrashed(); // com deletados
                })->paginate();
            }else if($filtros['situacao'] == 'inativo'){
                $contas = $this->contaBancariaRepository->scopeQuery(function($query){
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            }else{
                $contas = $this->contaBancariaRepository->paginate();
            }
        }else{
            $contas = $this->contaBancariaRepository->paginate();
        }

        return view('conta_bancarias.index', compact('title','breadcrumb','contas', 'filters'));
    }

    /**
     * Show the form for creating a new ContaBancaria.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Adicionar Conta Bancária";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addContaBancaria";

        return view('conta_bancarias.create', compact('title','breadcrumb'));
    }

    /**
     * Store a newly created ContaBancaria in storage.
     *
     * @param CreateContaBancariaRequest $request
     *
     * @return Response
     */
    public function store(CreateContaBancariaRequest $request)
    {
        $input = $request->all();
        $input['saldoInicial'] = str_replace('R$ ','',$input['saldoInicial']);
        //  $input['saldoInicial'] = str_replace(',','.',$input['saldoInicial']);

        $saldo = explode(",", $input['saldoInicial']);
        $parte1 = str_replace(".","", $saldo[0]);
        $valorFinal = $parte1 . "." . $saldo[1];

        $input['saldoInicial'] = $valorFinal;

        $date = DateTime::createFromFormat('d/m/Y',$input['dataSaldoInicial']);
        $usableDate = $date->format('Y-m-d');

        $input['dataSaldoInicial'] = $usableDate;

        $contaBancaria = $this->contaBancariaRepository->create($input);

        Flash::success('Conta Bancária salva com sucesso.');

        return redirect(route('contasbancarias.index'));
    }

    /**
     * Display the specified ContaBancaria.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $contaBancaria = $this->contaBancariaRepository->findWithoutFail($id);

        if (empty($cliente)) {
            Flash::error('Conta Bancária não encontrado');

            return redirect(route('contasbancarias.index'));
        }

        // Titulo da página
        $title = "Conta Bancária: ". $contaBancaria->banco;
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showContaBancaria";
        $breadcrumb->titulo = $contaBancaria->banco;

        return view('conta_bancarias.show', compact('title','breadcrumb','contaBancaria'));
    }

    /**
     * Show the form for editing the specified ContaBancaria.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $contaBancaria  = $this->contaBancariaRepository->findWithoutFail($id);
        
        

        if (empty($contaBancaria)) {
            Flash::error('Conta Bancária não encontrado!');

            return redirect(route('contasbancarias.index'));
        }

        // $contaBancaria->dataSaldoInicial = $contaBancaria->dataSaldoInicial->format('d/m/Y');
        // dd($contaBancaria);
        

        // Titulo da página
        $title = "Editar: ";
        // Breadcrumb 
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editContaBancaria";
        $breadcrumb->id = $contaBancaria->id;
        $breadcrumb->titulo = $contaBancaria->getName();

        return view('conta_bancarias.edit', compact('title','breadcrumb','contaBancaria', 'endereco'));
    }

    /**
     * Update the specified ContaBancaria in storage.
     *
     * @param  int              $id
     * @param UpdateContaBancariaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateContaBancariaRequest $request)
    {
        $request['saldoInicial'] = str_replace('R$ ','',$request['saldoInicial']);
        //  $input['saldoInicial'] = str_replace(',','.',$input['saldoInicial']);

        $saldo = explode(",", $request['saldoInicial']);
        $parte1 = str_replace(".","", $saldo[0]);
        $valorFinal = $parte1 . "." . $saldo[1];

        $request['saldoInicial'] = $valorFinal;
        // dd(  $valorFinal );

        $date = DateTime::createFromFormat('d/m/Y',$request['dataSaldoInicial']);
        $usableDate = $date->format('Y-m-d');


        $request['dataSaldoInicial'] = $usableDate;

        $contaBancaria = $this->contaBancariaRepository->findWithoutFail($id);

        if (empty($contaBancaria)) {
            Flash::error('Conta Bancária não encontrada');

            return redirect(route('contasbancarias.index'));
        }

        $contaBancaria = $this->contaBancariaRepository->update($request->all(), $id);

        Flash::success('Conta Bancária atualizada com sucesso.');

        return redirect(route('contasbancarias.index'));
    }

    /**
     * Remove the specified ContaBancaria from storage.
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
                $contaBancaria = ContaBancaria::find($id);
                $tesourarias = Tesouraria::where('conta_bancaria_id',$id)->get();
                $planoDeContas = PlanoDeContas::where('contabancaria_id',$id)->get();
                if(count( $tesourarias ) == 0 && count( $planoDeContas ) == 0){
                    $this->contaBancariaRepository->delete($id);
                } else{
                    $itensProibidos .= $contaBancaria->numeroConta.",";
                }
            }

            if( strlen($itensProibidos) > 0){
                $itensProibidos = substr($itensProibidos, 0, -1);
                DB::commit();
                Flash::error('As conta(s): "'.$itensProibidos. '" não podem ser inativadas porque são utilizadas em outras partes do sistema.');
                return response()->json([
                    'msg' => 'Sucesso'
                ]);
            }
            DB::commit();
            Flash::success('Conta(s) Bancária inativada(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch(\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Conta(s) Bancária!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }

    }
}
