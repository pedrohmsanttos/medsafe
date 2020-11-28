<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePedidoRequest;
use App\Http\Requests\UpdatePedidoRequest;
use App\Repositories\PedidoRepository;
use App\Repositories\ClienteRepository;
use App\Repositories\TipoProdutosRepository;
use App\Repositories\CategoriaProdutosRepository;
use App\Repositories\LancamentoReceberRepository;
use App\Repositories\EnderecoRepository;
use App\Repositories\ProdutosRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Pedido;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use App\Models\User;
use Auth;
use App\Traits\PedidoTrait;

class PedidoController extends AppBaseController
{
    /** @var  PedidoRepository */
    private $pedidoRepository;

    /** @var  ClienteRepository */
    private $clienteRepository;

    /** @var  EnderecoRepository */
    private $enderecoRepository;

    /** @var  CategoriaProdutosRepository */
    private $categoriaProdutosRepository;

    /** @var  TipoProdutosRepository */
    private $tipoProdutosRepository;

    /** @var  ProdutosRepository */
    private $produtoRepository;

    /** @var  LancamentoReceberRepository */
    private $lancamentoReceberRepository;

    // Logic
    use PedidoTrait;

    public function __construct(
        PedidoRepository $pedidoRepo,
        ClienteRepository $clienteRepo,
        CategoriaProdutosRepository $categoriaProdutosRepo,
        TipoProdutosRepository $tipoProdutosRepo,
        ProdutosRepository $produtoRepo,
        LancamentoReceberRepository $lancamentoReceberRepo,
        EnderecoRepository $enderecoRepo
    ) {
        $this->enderecoRepository = $enderecoRepo;
        $this->lancamentoReceberRepository = $lancamentoReceberRepo;
        $this->pedidoRepository  = $pedidoRepo;
        $this->clienteRepository = $clienteRepo;
        $this->categoriaProdutosRepository  = $categoriaProdutosRepo;
        $this->tipoProdutosRepository       = $tipoProdutosRepo;
        $this->produtoRepository            = $produtoRepo;
        //Set Permissions
        $this->middleware('permission:pedidos_listar', ['only' => ['index']]); 
        $this->middleware('permission:pedidos_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:pedidos_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:pedidos_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:pedidos_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Pedido.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();

        /** Titulo da página */
        $title = "Pedido";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "Pedido";
        
        $user = Auth::user();
        
        if (!$user->hasRole('cliente_user')) {
            /** Filtros */
            $request = $this->setOrderBy($request);
            $this->pedidoRepository->pushCriteria(new RequestCriteria($request));
            $filters = $this->pedidoRepository->filter($filtros);

            if (isset($filtros['situacao'])) {
                if ($filtros['situacao'] == 'all') {
                    $pedidos = $this->pedidoRepository->scopeQuery(function ($query) {
                        return $query->withTrashed(); // com deletados
                    })->paginate();
                } elseif ($filtros['situacao'] == 'inativo') {
                    $pedidos = $this->pedidoRepository->scopeQuery(function ($query) {
                        return $query->onlyTrashed(); // só os deletados
                    })->paginate();
                } else {
                    $pedidos = $this->pedidoRepository->paginate();
                }
            } else {
                $pedidos = $this->pedidoRepository->paginate();
            }
        } else {
            $filters = [];
            $req = new Request();
            $req->attributes->add(['search'=>'cliente_id:'.$user->cliente()->first()->id]);
            $req->attributes->add(['searchFields'=>'cliente_id:=']);
            $req->attributes->add(['orderBy' => 'id']);
            $req->attributes->add(['sortedBy' => 'desc']);
            //dd(new RequestCriteria($req));
            $this->pedidoRepository->pushCriteria(new RequestCriteria($req));
            $pedidos = $this->pedidoRepository->paginate();
        }

        return view('pedidos.index', compact('title', 'breadcrumb', 'pedidos', 'filters'));
    }

    /**
     * Show the form for creating a new Pedido.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        $title = "Pedido";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addPedido";

        $categorias          = $this->categoriaProdutosRepository->all();
        $tipos               = $this->tipoProdutosRepository->all();
        $produtos            = $this->produtoRepository->all();
        $clientes            = $this->clienteRepository->all();
        $usuarios            = User::all();
        $currentUser         = Auth::user();

        return view('pedidos.create', compact('title', 'breadcrumb', 'categorias', 'tipos', 'produtos', 'clientes', 'usuarios', 'currentUser'));
    }

    /**
     * Store a newly created Pedido in storage.
     *
     * @param CreatePedidoRequest $request
     *
     * @return Response
     */
    public function store(CreatePedidoRequest $request)
    {
        $input = $request->all();
        //dd($input);
        DB::beginTransaction();
        try {
            $this->__load($input);
            if(isset($input['cpf'])){
                $input['cpf']       = limpaMascara($input['cpf']);
            }
            //dd($input);
            $pedido = $this->pedidoRepository->create($this->getPedido());
            $pedido->itens()->createMany($this->getItens());
            $pedido->save();
            if($input['beneficio_terceiros'] == 'SIM'){
                unset($input['cliente_id']);
                $input['pedido_id'] = $pedido->id;
                $endereco = $this->enderecoRepository->create($input);
            }

            DB::commit();
            Flash::success('Pedido salvo com sucesso.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            Flash::error('Erro ao tentar cadastrar Pedido');
        }

        return redirect(route('pedidos.index'));
    }

    /**
     * Display the specified Pedido.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $pedido = $this->pedidoRepository->findWithoutFail($id);
        //dd($pedido);
        if (empty($pedido)) {
            Flash::error('Pedido não encontrado');

            return redirect(route('pedidos.index'));
        }

        /** Titulo da página */
        $title = "Pedido";
        $codigo = str_pad($pedido->id, 8, "0", STR_PAD_LEFT);
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showPedido";
        $breadcrumb->id = $pedido->id;
        $breadcrumb->titulo = $codigo;

        $lancamento = $this->lancamentoReceberRepository->findWhere(['pedido_id'=> $id])->first();

        return view('pedidos.show', compact('title', 'breadcrumb', 'pedido', 'codigo', 'lancamento'));
    }

    /**
     * Show the form for editing the specified Pedido.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pedido = $this->pedidoRepository->findWithoutFail($id);

        if (empty($pedido)) {
            Flash::error('Pedido não encontrado');

            return redirect(route('pedidos.index'));
        }

        // Titulo da página
        $title = "Pedido";
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editPedido";
        $breadcrumb->id = $pedido->id;
        $breadcrumb->titulo = $pedido->id;

        return view('pedidos.edit', compact('title', 'breadcrumb', 'pedido'));
    }

    /**
     * Update the specified Pedido in storage.
     *
     * @param  int              $id
     * @param UpdatePedidoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePedidoRequest $request)
    {
        $pedido = $this->pedidoRepository->findWithoutFail($id);

        if (empty($pedido)) {
            Flash::error('Pedido não encontrado');

            return redirect(route('pedidos.index'));
        }

        $pedido = $this->pedidoRepository->update($request->all(), $id);

        Flash::success('Pedido atualizado com sucesso.');

        return redirect(route('pedidos.index'));
    }

    /**
     * Remove the specified Pedido from storage.
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
                $this->pedidoRepository->delete($id);
            }

            DB::commit();
            Flash::success('Pedido(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Pedido(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }

    /**
     * Copy registe from database.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function copy($id)
    {
        $pedido_cp = $this->pedidoRepository->findWithoutFail($id);

        if (empty($pedido_cp)) {
            Flash::error('Pedido não encontrado');

            return redirect(route('pedidos.index'));
        }

        /** Titulo da página */
        $title = "Pedido (Copia de ".$id.")";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addPedido";

        $categorias          = $this->categoriaProdutosRepository->all();
        $tipos               = $this->tipoProdutosRepository->all();
        $produtos            = $this->produtoRepository->all();
        $clientes            = $this->clienteRepository->all();
        $usuarios            = User::all();
        $currentUser         = Auth::user();

        return view('pedidos.create', compact('title', 'breadcrumb', 'pedido_cp', 'categorias', 'tipos', 'produtos', 'clientes', 'usuarios', 'currentUser'));
    }

    /**
     * transferir.
     *
     * @return Response
     */
    public function transferir()
    {
        /** Titulo da página */
        $title = "Transferir Pedidos";
        
        /** Breadcrumb */
        $breadcrumb       = new \stdClass;
        $breadcrumb->nome = "addNegocio";

        /** Attrs */
        $usuarios    = User::all();
        $currentUser = Auth::user();

        return view('pedidos.transferir', compact('title', 'breadcrumb', 'usuarios', 'currentUser'));
    }

    /**
     * doTransferir.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function doTransferir(Request $request)
    {
        $input = $request->all();
        
        if (isset($input['usuario_operacao_id'])) {
            DB::beginTransaction();
            try {
                $negocio  = Pedido::where('usuario_operacao_id', Auth::user()->id)
                    ->update(['usuario_operacao_id' => $input['usuario_operacao_id']]);

                DB::commit();
                Flash::success('Pedido(s) transferido(s) com sucesso.');
            } catch (\Exception $e) {
                DB::rollBack();
                Flash::error('Erro ao tentar transferir Pedido(s)');
            }
        }

        return redirect(route('pedidos.index'));
    }
}
