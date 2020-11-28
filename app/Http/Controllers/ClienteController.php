<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Repositories\ClienteRepository;
use App\Repositories\EnderecoRepository;
use App\Repositories\EspecialidadeRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Cliente;
use App\Models\Tesouraria;
use App\Models\LancamentoReceber;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Auth;
use DB;

class ClienteController extends AppBaseController
{
    /** @var  ClienteRepository */
    private $clienteRepository;
    
    /** @var  EnderecoRepository */
    private $enderecoRepository;

    /** @var  EspecialidadeRepository */
    private $especialidadeRepository;

    public function __construct(
        ClienteRepository $clienteRepo,
        EnderecoRepository $enderecoRepo,
        EspecialidadeRepository $especialidadeRepository
    ) {
        $this->clienteRepository = $clienteRepo;
        $this->enderecoRepository = $enderecoRepo;
        $this->especialidadeRepository = $especialidadeRepository;
        // Set Permissions
        $this->middleware('permission:cliente_listar', ['only' => ['index']]);
        $this->middleware('permission:cliente_adicionar', ['only' => ['create', 'store']]);
        //$this->middleware('permission:cliente_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:cliente_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:cliente_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Cliente.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();
        /** Titulo da página */
        $title = "Clientes";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "clientes";
        
        
        $this->clienteRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->clienteRepository->filter($filtros);
        
        if (isset($filtros['situacao'])) {
            if ($filtros['situacao'] == 'all') {
                $clientes = $this->clienteRepository->scopeQuery(function ($query) {
                    return $query->withTrashed(); // com deletados
                })->paginate();
            } elseif ($filtros['situacao'] == 'inativo') {
                $clientes = $this->clienteRepository->scopeQuery(function ($query) {
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            } else {
                $clientes = $this->clienteRepository->paginate();
            }
        } else {
            $clientes = $this->clienteRepository->paginate();
        }

        return view('clientes.index', compact('title', 'breadcrumb', 'clientes', 'filters'));
    }

    /**
     * Show the form for creating a new Cliente.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Adicionar Cliente";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addCliente";

        $especialidades = $this->especialidadeRepository->all();

        $cliente = new \App\Models\Cliente;

        $cliente->especialidade_id ="";

        return view('clientes.create', compact('title', 'breadcrumb', 'especialidades'));
    }

    /**
     * Store a newly created Cliente in storage.
     *
     * @param CreateClienteRequest $request
     *
     * @return Response
     */
    public function store(CreateClienteRequest $request)
    {
        $input = $request->all();
        // temp
        if (isset($input['funcao_pj'])) {
            $input['funcao'] = $input['funcao_pj'];
        }
        if (isset($input['CNPJCPF_pj'])) {
            $input['CNPJCPF'] = $input['CNPJCPF_pj'];
        }
        if (isset($input['nomeFantasia_pj'])) {
            $input['nomeFantasia'] = $input['nomeFantasia_pj'];
        }
        if (isset($input['telefone_pj'])) {
            $input['telefone'] = $input['telefone_pj'];
        }
        if (isset($input['email_pj'])) {
            $input['email'] = $input['email_pj'];
        }
        if (isset($input['dia_vencimento_pj'])) {
            $input['dia_vencimento'] = $input['dia_vencimento_pj'];
        }

        DB::beginTransaction();
        try {
            $cliente  = $this->clienteRepository->create($input);
            $input['cliente_id'] = $cliente->id;

            $input['CNPJCPF']   = limpaMascara($input['CNPJCPF']);
            $input['CPF']       = limpaMascara($input['CPF']);
        
            $endereco = $this->enderecoRepository->create($input);

            DB::commit();
            Flash::success('Cliente salvo com sucesso.');
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Erro ao tentar cadastrar cliente');
        }

        return redirect(route('clientes.index'));
    }

    /**
     * Display the specified Cliente.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cliente = $this->clienteRepository->findWithoutFail($id);

        if (empty($cliente)) {
            Flash::error('Cliente não encontrado');

            return redirect(route('clientes.index'));
        }

        // Titulo da página
        $title = "Cliente: ". $cliente->razaoSocial;
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showCliente";
        $breadcrumb->titulo = $cliente->razaoSocial;

        return view('clientes.show', compact('title', 'breadcrumb', 'cliente'));
    }

    /**
     * Show the form for editing the specified Cliente.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $cliente  = $this->clienteRepository->findWithoutFail($id);
        $endereco = $cliente->endereco()->first();
        
        if (empty($cliente)) {
            Flash::error('Cliente não encontrado!');

            return redirect(route('clientes.index'));
        } elseif (Auth::user()->id != $cliente->user_id && !Auth::user()->hasRole('super_user')) {
            return abort(403);
        }

        // Titulo da página
        $title = "Editar: ". $cliente->razaoSocial;
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editCliente";
        $breadcrumb->id = $cliente->id;
        $breadcrumb->titulo = $cliente->razaoSocial;

        $especialidades = $this->especialidadeRepository->all();

        return view('clientes.edit', compact('title', 'breadcrumb', 'cliente', 'endereco', 'especialidades'));
    }

    /**
     * Update the specified Cliente in storage.
     *
     * @param  int              $id
     * @param UpdateClienteRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateClienteRequest $request)
    {
        $input = $request->all();
        $cliente = $this->clienteRepository->findWithoutFail($id);
        $clienteEndereco = $cliente->endereco()->first();
        // temp
        if (isset($input['funcao_pj'])) {
            $input['funcao'] = $input['funcao_pj'];
        }
        if (isset($input['CNPJCPF_pj'])) {
            $input['CNPJCPF'] = $input['CNPJCPF_pj'];
        }
        if (isset($input['nomeFantasia_pj'])) {
            $input['nomeFantasia'] = $input['nomeFantasia_pj'];
        }
        if (isset($input['telefone_pj'])) {
            $input['telefone'] = $input['telefone_pj'];
        }
        if (isset($input['email_pj'])) {
            $input['email'] = $input['email_pj'];
        }
        if (isset($input['dia_vencimento_pj'])) {
            $input['dia_vencimento'] = $input['dia_vencimento_pj'];
        }

        if (empty($cliente)) {
            Flash::error('Cliente não encontrado!');

            return redirect(route('clientes.index'));
        } elseif (Auth::user()->id != $cliente->user_id && !Auth::user()->hasRole('super_user')) {
            return abort(403);
        }

        $cliente = $this->clienteRepository->update($input, $id);
        if (!empty($clienteEndereco)) {
            $endereco = $this->enderecoRepository->update($request->all(), $clienteEndereco->id);
        } else {
            $input = $request->all();
            $input['cliente_id'] = $cliente->id;
            $endereco = $this->enderecoRepository->create($input);
        }
        

        Flash::success('Cliente atualizado com sucesso.');

        return redirect(route('clientes.index'));
    }

    /**
     * Remove the specified Cliente from storage.
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
                $lancamentos = LancamentoReceber::where('cliente_id',$id)->get();
                $pedidos = Pedido::where('cliente_id',$id)->get();
                $cliente = Cliente::find($id);
                $tesourarias = Tesouraria::where('cliente_id',$id)->get();
                if(count( $lancamentos ) == 0 && count( $tesourarias ) == 0 && count( $pedidos ) == 0){
                    $this->clienteRepository->delete($id);
                } else{
                    $itensProibidos .= $cliente->nomeFantasia.",";
                }
                
            }
            if( strlen($itensProibidos) > 0){
                $itensProibidos = substr($itensProibidos, 0, -1);
                DB::commit();
                Flash::error('Os Cliente(s): "'.$itensProibidos. '" não podem ser inativados porque são utilizados em outras partes do sistema.');
                return response()->json([
                    'msg' => 'Sucesso'
                ]);
            }

            DB::commit();
            Flash::success('Cliente(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Cliente(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
