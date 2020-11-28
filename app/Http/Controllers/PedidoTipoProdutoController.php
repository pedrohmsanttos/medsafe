<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePedidoTipoProdutoRequest;
use App\Http\Requests\UpdatePedidoTipoProdutoRequest;
use App\Repositories\PedidoTipoProdutoRepository;
use App\Repositories\ProdutosRepository;
use App\Repositories\ProdutoTipoProdutoRepository;
use App\Repositories\ClienteRepository;
use App\Repositories\TipoProdutosRepository;
use App\Repositories\CategoriaProdutosRepository;
use App\Repositories\EnderecoRepository;
use App\Repositories\PedidoRepository;
use App\Repositories\FormaDePagamentoRepository;
use App\Repositories\ContaBancariaRepository;
use App\Repositories\LancamentoReceberRepository;
use App\Models\User;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use DateTime;
use Auth;

class PedidoTipoProdutoController extends AppBaseController
{
    /** @var  PedidoTipoProdutoRepository */
    private $pedidoTipoProdutoRepository;
    
    /** @var  TipoProdutosRepository */
    private $tipoProdutosRepository;
    
    /** @var  CategoriaProdutosRepository */
    private $categoriaProdutosRepository;
    
    /** @var  ProdutoTipoProdutoRepository */
    private $produtoTipoProdutoRepository;
    
    /** @var  ProdutoRepository */
    private $produtoRepository;
    
    /** @var  ClienteRepository */
    private $clienteRepository;
    
    /** @var  EnderecoRepository */
    private $enderecoRepository;

    /** @var  PedidoRepository */
    private $pedidoRepository;

    /** @var  LancamentoReceberRepository */
    private $lancamentoReceberRepository;

    /** @var  formaPagamentoRepository */
    private $formaPagamentoRepository;

    /** @var  ContasbancariasPagarRepository */
    private $contasbancariasPagarRepository;

    public function __construct(
        PedidoTipoProdutoRepository $pedidoTipoProdutoRepo,
        TipoProdutosRepository $tipoProdutosRepo,
        CategoriaProdutosRepository $categoriaProdutosRepo,
        ProdutoTipoProdutoRepository $produtoTipoProdutoRepository,
        ProdutosRepository $produtoRepo,
        EnderecoRepository $enderecoRepo,
        ClienteRepository $clienteRepository,
        PedidoRepository $pedidoRepository,
        LancamentoReceberRepository $lancamentoReceberRepository,
        FormaDePagamentoRepository $formaPagamentoRepo,
        ContaBancariaRepository $contasBancariasRepo
        ) {
        $this->pedidoTipoProdutoRepository  = $pedidoTipoProdutoRepo;
        $this->tipoProdutosRepository       = $tipoProdutosRepo;
        $this->categoriaProdutosRepository  = $categoriaProdutosRepo;
        $this->produtoTipoProdutoRepository = $produtoTipoProdutoRepository;
        $this->produtoRepository            = $produtoRepo;
        $this->enderecoRepository           = $enderecoRepo;
        $this->clienteRepository            = $clienteRepository;
        $this->pedidoRepository             = $pedidoRepository;
        $this->lancamentoReceberRepository  = $lancamentoReceberRepository;
        $this->formaPagamentoRepository       = $formaPagamentoRepo;
        $this->contasbancariasPagarRepository = $contasBancariasRepo;

        $this->middleware('permission:pedidos_listar', ['only' => ['index']]);
        $this->middleware('permission:pedidos_adicionar', ['only' => ['create', 'store']]);
        $this->middleware('permission:pedidos_editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:pedidos_deletar', ['only' => ['destroy']]);
        $this->middleware('permission:pedidos_visualizar', ['only' => ['show']]);
    }

    /**
     * Display a listing of the PedidoTipoProduto.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filtros = $request->all();

        /** Titulo da página */
        $title = "Pedidos";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "pedidotipoproduto";
        /** Filtros */
        /*$this->pedidoTipoProdutoRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->pedidoTipoProdutoRepository->filter($filtros);*/

        $this->pedidoRepository->pushCriteria(new RequestCriteria($request));
        $filters = $this->pedidoRepository->filter($filtros);

        if (isset($filtros['situacao'])) {
            if ($filtros['situacao'] == 'all') {
                //$pedidoTipoProdutos = $this->pedidoTipoProdutoRepository->scopeQuery(function ($query) {
                $pedidos = $this->pedidoRepository->scopeQuery(function ($query) {
                    return $query->withTrashed(); // com deletados
                })->paginate();
            } elseif ($filtros['situacao'] == 'inativo') {
                //$pedidoTipoProdutos = $this->pedidoTipoProdutoRepository->scopeQuery(function ($query) {
                $pedidos = $this->pedidoRepository->scopeQuery(function ($query) {
                    return $query->onlyTrashed(); // só os deletados
                })->paginate();
            } else {
                //$pedidoTipoProdutos = $this->pedidoTipoProdutoRepository->paginate();
                $pedidos = $this->pedidoRepository->orderBy('id', 'desc')->paginate();
            }
        } else {
            //$pedidoTipoProdutos = $this->pedidoTipoProdutoRepository->paginate();
            $pedidos = $this->pedidoRepository->orderBy('id', 'desc')->paginate();
        }

        // dd($pedidoTipoProdutos);
        return view('pedido_tipo_produtos.index', compact('title', 'breadcrumb', 'pedidos', 'filters'));
    }

    /**
     * Show the form for creating a new PedidoTipoProduto.
     *
     * @return Response
     */
    public function create()
    {
        /** Titulo da página */
        //$title = "Pedido Tipo Produto";
        $title = "Fazer Pedidos";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "addPedidoTipoProduto";

        $categorias          = $this->categoriaProdutosRepository->all();
        $tipos               = $this->tipoProdutosRepository->all();
        $produtos            = $this->produtoRepository->all();
        $clientes            = $this->clienteRepository->all();
        $usuarios            = User::all();
        $currentUser         = Auth::user();

        return view('pedido_tipo_produtos.create', compact('title', 'breadcrumb', 'categorias', 'tipos', 'produtos', 'usuarios', 'currentUser', 'clientes'));
    }

    /**
     * Store a newly created PedidoTipoProduto in storage.
     *
     * @param CreatePedidoTipoProdutoRequest $request
     *
     * @return Response
     */
    public function store(CreatePedidoTipoProdutoRequest $request)
    {
        $input = $request->all();

        $valorTotal = 0;
        $itensPedido = json_decode($input['itens_pedido']);

        if (!is_array($itensPedido)) {
            Flash::error('É preciso ter pelo menos um item!');
            return redirect(url('pedidoTipoProdutos/create'));
        }
        
        foreach ($itensPedido as $item) {
            $valorTotal += (float)$item->total;
        }

        $currentUser    = Auth::user();
        
        DB::beginTransaction();
        try {
            $dataPedido = array();
            $dataPedido['status_pedido_id']     = '1';
            $dataPedido['cliente_id']           = $input['cliente_id'];
            $dataPedido['usuario_operacao_id']  = $currentUser->id;
            $dataPedido['data_vencimento']      = dateBRtoSQL($input['data_vencimento']);
            $dataPedido['valor_total']          = $valorTotal;
            $dataPedido['valor_desconto']       = 0;
            
            $pedido                             = $this->pedidoRepository->create($dataPedido);
            
            foreach ($itensPedido as $item) {
                $dataPedidoTipoProduto = array();

                $dataPedidoTipoProduto['pedido_id']            = $pedido->id;
                $dataPedidoTipoProduto['categoria_produto_id'] = $item->categoriaId;
                $dataPedidoTipoProduto['tipo_produto_id']      = $item->tipoProdutoId;
                $dataPedidoTipoProduto['produto_id']           = $item->produtoId;
                $dataPedidoTipoProduto['valor']                = str_replace(",", ".", str_replace('.', '', $item->valorU));
                $dataPedidoTipoProduto['valor_parcela']        = $item->valorParcela;
                $dataPedidoTipoProduto['valor_desconto']       = 0;
                $dataPedidoTipoProduto['valor_final']          = $item->total;
                $dataPedidoTipoProduto['quantidade_parcela']   = $item->qtdParcela;
                $dataPedidoTipoProduto['quantidade']           = $item->quantidade;

                $pedidoTipoProduto  = $this->pedidoTipoProdutoRepository->create($dataPedidoTipoProduto);
            }

            // gera um lançamento
            $dataLancamento                     = array();
            $ultimaDataVencimento               = dateBRtoSQL($input['data_vencimento']);
            $aux                                = rand(0, 9);
            $dataLancamento['cliente_id']       = $input['cliente_id'];
            $dataLancamento['data_vencimento']  = $ultimaDataVencimento;
            $dataLancamento['data_emissao']     = date('Y-m-d');
            $dataLancamento['valor_titulo']     = $valorTotal;
            $dataLancamento['numero_documento'] = str_pad(date('dmYhis') . $input['cliente_id'] .$aux, 16, "0", STR_PAD_RIGHT);
            $dataLancamento['pedido_id']        = $pedido->id;

            $lancamento = $this->lancamentoReceberRepository->create($dataLancamento);
            
            DB::commit();
            Flash::success('Pedido salvo com sucesso.');
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Erro ao tentar salvar Pedido');
        }

        return redirect(route('pedidoTipoProdutos.index'));
    }

    /**
     * Display the specified PedidoTipoProduto.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** Titulo da página */
        $title = "Pedidos";
        /** Breadcrumb */
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "showPedidoTipoProduto";
        
        $pedidoTipoProduto = $this->pedidoTipoProdutoRepository->findWithoutFail($id);

        if (empty($pedidoTipoProduto)) {
            Flash::error('Pedido Tipo Produto não encontrado');

            return redirect(route('pedidoTipoProdutos.index'));
        }

        return view('pedido_tipo_produtos.show', compact('title', 'breadcrumb', 'pedidoTipoProduto'));
    }

    /**
     * Show the form for editing the specified PedidoTipoProduto.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pedido                 = $this->pedidoRepository->findWithoutFail($id);
        $itens                  = $pedido->getItensPedido();
        $lancamentoRecebers     = $pedido->getLancamentos();

        if (empty($pedido)) {
            Flash::error('Pedido não encontrado');

            return redirect(route('pedidoTipoProdutos.index'));
        }

        $pedidoTipoProduto = $this->pedidoTipoProdutoRepository->findWithoutFail($pedido->pedidoTipoProdutos->first()->id);

        // Titulo da página
        $title = "Pedidos";
        // Breadcrumb
        $breadcrumb = new \stdClass;
        $breadcrumb->nome = "editPedidoTipoProduto";
        $breadcrumb->id = $pedido->id;
        $breadcrumb->titulo = $pedido->id;

        $categorias          = $this->categoriaProdutosRepository->all();
        $tipos               = $this->tipoProdutosRepository->all();
        $produtos            = $this->produtoRepository->all();
        $clientes            = $this->clienteRepository->all();
        $formaPagamentos     = $this->formaPagamentoRepository->all();
        $contasbancarias     = $this->contasbancariasPagarRepository->all();
        $usuarios            = User::all();
        $currentUser         = Auth::user();

        return view('pedido_tipo_produtos.edit', compact('title', 'breadcrumb', 'contasbancarias', 'formaPagamentos', 'pedido', 'pedidoTipoProduto', 'categorias', 'tipos', 'produtos', 'clientes', 'itens', 'lancamentoRecebers'));
    }

    /**
     * Update the specified PedidoTipoProduto in storage.
     *
     * @param  int              $id
     * @param UpdatePedidoTipoProdutoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePedidoTipoProdutoRequest $request)
    {
        $pedidoTipoProduto = $this->pedidoTipoProdutoRepository->findWithoutFail($id);

        if (empty($pedidoTipoProduto)) {
            Flash::error('Pedido Tipo Produto não encontrado');

            return redirect(route('pedidoTipoProdutos.index'));
        }

        $pedidoTipoProduto = $this->pedidoTipoProdutoRepository->update($request->all(), $id);

        Flash::success('Pedido Tipo Produto atualizado com sucesso.');

        return redirect(route('pedidoTipoProdutos.index'));
    }

    /**
     * Remove the specified PedidoTipoProduto from storage.
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
                $this->pedidoTipoProdutoRepository->delete($id);
            }

            DB::commit();
            Flash::success('Pedido Tipo Produto(s) inativado(s) com sucesso.');
            return response()->json([
                'msg' => 'Sucesso',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Flash::error('Error ao inativar Pedido Tipo Produto(s)!');
            return response()->json([
                'msg' => 'Error',
            ]);
        }
    }
}
